$(document).ready(function() {
    var i = $('#jurnal_detail tr').length;
    $(".add").on('click',function(){
        /*var n_amount = $("#amount_'+i+'").val();
         if (n_amount==0){
         alert("Maaf, Nominal transaksi harus di isi terlebih dahulu!");
         return false;
         }*/

        html = '<tr>';
        html += '<td><input class="case" type="checkbox" /></td>';
        html += '<td><input type="hidden" name="nomor[]" value="'+ i + '"><input type="hidden" data-type="id" class="form-control" name="acc_id_'+i+'" id="accID_'+i+'" >';
        html += '<div class="input-group"><input type="text" data-type="acc_name" class="form-control autocomplete_txt" placeholder="Nama Akun..."  required name="acc_name_'+i+'" id="accName_'+i+'">';
        html += '<span class="input-group-addon"></span>';
        html += '</td>';
        html += '<td><input type="text" data-type="ldg_pk" class="form-control autocomplete_ldg" onkeypress="return IsNumeric(event);" name="ldg_pk_'+i+'" id="ldg_pk_'+i+'"></td>';
        html += '<td><input type="number" class="form-control totalLinePrice_Debet" onkeypress="return IsNumeric(event);" value="0" name="debet_'+i+'" id="debet_'+i+'"></td>';
        html += '<td><input type="number" class="form-control totalLinePrice_Credit" onkeypress="return IsNumeric(event);" value="0" name="credit_'+i+'" id="credit_'+i+'"></td>';
        html += '<td><input type="text" class="form-control" placeholder="Memo Jurnal..." name="memo_'+i+'" id="memo_'+i+'" > </td>';
        html += '</tr>';
        $('#jurnal_detail').append(html);
        //$("#jml_baris").val(i);
        i++;
    });

    //to check all checkboxes
    $(document).on('change','#check_all',function(){
        $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
    });

    //deletes the selected table rows
    $(".del").on('click', function() {
        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false);
        calculateTotal();
    });

    //autocomplete script
    $(document).on('focus','.autocomplete_txt',function(){
        type = $(this).data('type');

        if(type =='id' )autoTypeNo=0;
        if(type =='acc_name' )autoTypeNo=1;

        $(this).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url : 'views/FI/get_akun.php',
                    dataType: "json",
                    method: 'post',
                    data: {
                        name_startsWith: request.term,
                        type: type
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            var code = item.split("|");
                            return {
                                label: code[autoTypeNo],
                                value: code[autoTypeNo],
                                data : item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            appendTo: "#modal-fullscreen",
            select: function( event, ui ) {
                var names = ui.item.data.split("|");
                id_arr = $(this).attr('id');
                id = id_arr.split("_");
                console.log(names, id);

                $('#accID_'+id[1]).val(names[0]);
                $('#accName_'+id[1]).val(names[1]);
            }
        });
    });

    //Delete
    $('#modal-konfirmasi').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan

        // Untuk mengambil nilai dari data-id="" yang telah kita tempatkan pada link hapus
        var id = div.data('id')

        //alert ("ID Nya adalah " + id );
        var modal = $(this)

        // Mengisi atribut href pada tombol ya yang kita berikan id hapus-true pada modal.
        modal.find('#hapus-true').attr("href","classes/crud_jurnal.php?p=del&id="+id);

    });

    $('.print_class').on('click',function(){
        var id = $(this).data('id');
        //alert ("Yang di klik Unique ID : " + uuid);
        //console.log(id);
        $.ajax({
            url: "views/FI/printjv.php?id="+ id,
            //url: 'views/FA/printjv.php',
            //data: {id:id},
            method:'post',
            success: function(result){
                $('#print_content').html(result);
                $('#myModal').modal('show');
            }
        });
    });

    $('.cari_jurnal').on('click',function(){
        var from_date = $('#from').val();
        var to_date = $('#to').val();
        //var dataString = 'from_date=' + from_date + '&to_date=' + to_date;

        //alert ("Yang di klik Unique ID : " + dataString);
        //console.log(tgl_awal);
        //console.log(tgl_akhir);
        $.ajax({
            url: 'views/FI/jvsearch.php',
            type:'post',
            data:{from: $('input#from').val(),to:$('input#to').val()},
            success: function(hasildata){
                $('table#list_jurnal tbody').html(hasildata);
                //console.log(hasildata);
            }
        });
    });

    function printVoucher(id) {
        $('#printBtn').button('loading');
        printContent = $('#'+id).html();
        //console.log(printContent);
        $('#PrintIframe').contents().find('html').html(printContent);
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf ("MSIE");
        var iframe = document.getElementById('PrintIframe');
        console.log(iframe);
        /*if (msie > 0) {
         $('#printBtn').button('reset');
         iframe.contentWindow.document.execCommand('print', false, null);
         } else {*/
        //iframe.focus();
        iframe.contentWindow.print();
        $('#printBtn').button('reset');
        //}
    }

    //price change
    $(document).on('change keyup blur','.totalLinePrice_Debet',function(){
        id_arr = $(this).attr('id');
        id = id_arr.split("_");
        price = $('#debet_'+id[1]).val();
        calculateTotal();
    });
    $(document).on('change keyup blur','.totalLinePrice_Credit',function(){
        id_arr = $(this).attr('id');
        id = id_arr.split("_");
        price = $('#credit_'+id[1]).val();
        calculateTotal();
    });

    //total price calculation
    function calculateTotal(){
        debet = 0 ; credit = 0;
        $('.totalLinePrice_Debet').each(function(){
            if($(this).val() != '' )debet += parseFloat( $(this).val() );
        });
        $('#subTotal_debet').val( debet);
        $('.totalLinePrice_Credit').each(function(){
            if($(this).val() != '' )credit += parseFloat( $(this).val() );
        });
        $('#subTotal_credit').val( credit);
    }

    //It restrict the non-numbers
    var specialKeys = new Array();
    specialKeys.push(8,46); //Backspace
    function IsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        console.log( keyCode );
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        return ret;
    }
    //tabel lookup
    $(function () {
        $("#list_jurnal").dataTable();
    });
});