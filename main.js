$('button[name="sepeteEkle"]').click(function () {
    var urunid = $(this).attr('urunid');
    var urunAdet = $('input[name="urunadet[' + urunid + ']"]').val();
    
    $.ajax({
        url: 'sepet.php',
        type: 'post',
        data: {'urunid': urunid, 'urunadet': urunAdet},
        dataType: 'json',
        success: function(resp) {
            alert(resp.mesaj);
        },
        error: function(xhr, status, error) {
            console.error('AJAX hatası:', error);
        }
    });
});
