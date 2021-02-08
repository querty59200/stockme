import '../../css/luggage/luggage.css';

import axios from 'axios';

function onClickBtnReaction(event) {

    const url = this.href;
    const i = this.querySelector('i');

    event.preventDefault();

    axios.get(url)
        .then((response) => {
            spanCount.textContent = response.data.reactions;
            if(i.classList.contains("fas")){
                i.classList.replace("fas","far");
            } else {
                i.classList.replace("far","fas");
            }
        })
        .catch((error) => {
            if(error.response.status === 403){
                window.alert("Vous devez être connecté pour liker un bagage");
            } else {
                window.alert("Réssayer plus tard");
            }
        })
}

function onClickBtnAddCart(event) {

    const url = this.href;

    event.preventDefault();

    axios.get(url)
        .then((response) => {
            document.querySelector('span#js-nbItem').textContent = response.data.nbAllItemsSelected;
        })
        .catch((error) => {
            window.alert("Réssayer plus tard");
        })
}

window.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll('a.js-like').forEach(
        function (link) {
            link.addEventListener('click', onClickBtnReaction);
        }
    )

    document.querySelectorAll('a.js-add').forEach(
        function (link) {
            link.addEventListener('click', onClickBtnAddCart);
        }
    )
})