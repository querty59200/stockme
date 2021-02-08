// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

let modal = null;
let fragment = null;
let target = null;
const focusableExisitingBalises = 'button, input, a, textarea';
let focusablesBalises = [];
let previoulyFocusedElmnt = null;

const openModal = async function (e){
    e.preventDefault();
    target = e.target.getAttribute('href');
    modal = await loadModal(target);
    // Ajout de la classe .intercalaire
    modal.classList.add('intercalaire');
    // Ajout de la classe .modal-wrapper à la balise enfant <div>
    modal.childNodes[1].classList.add('modal-wrapper');
    modal.childNodes[1].classList.add('js-modal-stop');
    let btnExit = document.createElement('button')
    btnExit.appendChild(document.createTextNode("Fermer"));
    modal.childNodes[1].appendChild(btnExit);
    btnExit.classList.add('js-modal-close');
    // Ajout du code nécessaire à la fermeture de la modal
    modal.addEventListener('click', closeModal)
    modal.querySelector('.js-modal-close').addEventListener('click', closeModal);
    modal.querySelector('.js-modal-stop').addEventListener('click', stopPropagation);
};

const closeModal = function (e){
    let balise = target.replace("/", "#");
    document.querySelector(balise).remove();
}

const stopPropagation = function (e) {
    e.stopPropagation();
}

const focusInModal = function(e){
    e.preventDefault();
    let index = focusablesBalises.findIndex(f => f === modal.querySelector(":focus")); // Renvoie l'index du tableau des élts focusables de la modal
    // Equivaut à function(f) { return f === modal.querySelector(":focus")}; -1 si Rien ou l'index de l'élément

    if(e.shiftKey === true) {
        index--;
    } else {
        index++;
    }
    if(index >= focusablesBalises.length) index = 0;
    if(index < 0) index = focusablesBalises.length - 1 ;

    focusablesBalises[index].focus();

}

const escape = function (e) {
    if(e.key === 'Escape' || e.key === 'Esc'){
        closeModal(e);
    }
}

const tab = function (e) {
    if(e.key === 'Tab') {
        focusInModal(e)
    }
}

const loadModal = async function (target) {
    await $.ajax({
        url: target,
        type: 'GET',
        success: function (response) {
            // Transforme la réponse en un objet #document-fragment contenant le fragment Html
            fragment = document.createRange().createContextualFragment(response);
            // On récupère le fragment identifié par son id
            fragment = fragment.querySelector(target.replace("/", "#"));
            if(fragment === null) throw `l'élément n'a pas été trouvé`;
            // Injection du fragment htmlisé dans la balise
            $('#myModal').html(fragment);
        }
    })
    return fragment;
}

// const downloadMsg = function (e) {
//
//         e.preventDefault();
//
//         $.ajax({
//             type: attr(e.target.getAttribute('method')),
//             url: attr(e.target.getAttribute('action')),
//             data: serialize(),
//             success: function (data) {
//                 console.log('Submission was successful.');
//                 console.log(data);
//             },
//             error: function (data) {
//                 console.log('An error occurred.');
//                 console.log(data);
//             },
//         });
// }

const jsModal = document.querySelectorAll('.js-modal').forEach((item) => {
    item.addEventListener('click', openModal)
});

const jsModalInAjax = document.querySelectorAll('.js-modal-ajax').forEach((item) => {
    item.addEventListener('click', openModal)
});

window.addEventListener('keydown', escape);
window.addEventListener('keydown', tab);

// const btn = document.getElementById('s-modal-download-msg').addEventListener('click', downloadMsg);
