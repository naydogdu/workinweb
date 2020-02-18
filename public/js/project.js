$(function() {

// Copie d'un exemple sur internet, à complétement changer
    $(document).on('click', 'button.btn-add-participant[id^=participant]', function() {

        var lastNum=$("button.participant1").length;
        var newNum = lastNum + 1;
        var e=null;
        e = $( "#echantillon" + lastNum ).clone();
        e.attr('id', 'echantillon' + newNum);
        e.children(".control-label").text("Produit " + newNum);
        e.children(".control-label").attr("for", "echant" + newNum);;
        e.find("#echant" + lastNum).attr("id", "echant" + newNum);
        e.find("#qte" + lastNum).attr("id", "qte" + newNum);
        e.find("#gsb_ajout_echantillon" + lastNum).attr("id", "gsb_ajout_echantillon" + newNum);
        e.find("#gsb_echantillon" + lastNum).attr("id", "gsb_echantillon" + newNum);
        
        $(e).insertBefore( "#echantillons" );
        
        $("#gsb_echantillon" + lastNum).hide();
        $("#gsb_echantillon" + newNum).show();

    }); 

});