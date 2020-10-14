$('.ikona').click(function(){
    let slikaPutanja=$(this).attr('slika');
    console.log(slikaPutanja);
    $('#slika').attr('src',slikaPutanja);
    var popup = new Foundation.Reveal($('#exampleModal1'));
    popup.open();

    
    //$('#exampleModal1').foundation();
    //$('#exampleModal1').foundation('open');


});