(function () {

    const btnDelete = document.querySelectorAll('.btn-danger');

    const modal = document.querySelector('#modal');
    const modalBtns = modal.querySelectorAll('button');

    let urlDelete = ''; // Url de la ressource à supprimer


    btnDelete.forEach(function (btn) {

        btn.addEventListener('click', function (e){

            e.preventDefault(); // Bloque la requête http Possibilité de faire confirmer

            let topPosition = e.clientY; // Déplacement du modal
            modal.style.top = topPosition + 'px';

            //console.log('click Confirme le !');

            //Mémorisation de l'url permettant la suppression
            urlDelete = e.target.href;
            // console.log(urlDelete);

        })
    })

    // Confirmation de la suppression
    modalBtns[0].addEventListener('click', function(e){
        // console.log('oui');
        window.location.href = urlDelete; // Redirection : requête GET sur l'url fourni
    })

    // Annulation de la suppression
    modalBtns[1].addEventListener('click', function(e){

        modal.style.top = '-100px';
    })

})()