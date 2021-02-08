import axios from 'axios';

function onClickBtnOneItemChangeCart(event) {

    const url = this.href;
    const nbItemsSelected = document.querySelector(".js-nbItemsSelected");
    const totalPriceByItem = document.querySelector(".js-totalPriceByItem");
    const totalPriceItems = document.querySelector("#js-totalPriceItems");

    event.preventDefault()
    // kk

    axios.get(url)
        .then((response) => {
            nbItemsSelected.textContent = response.data.nbItemsSelected;
            totalPriceByItem.textContent = response.data.priceTotalByItem;
            totalPriceItems.textContent = response.data.priceTotalForAll;
        })
        .catch((error) => {
            window.alert(error.message);
        })
}

    document.querySelectorAll('.js-minusNbItem').forEach(
        function (link) {
            link.addEventListener('click', onClickBtnOneItemChangeCart);
        })
    document.querySelectorAll('.js-plusNbItem').forEach(
        function (link) {
            link.addEventListener('click', onClickBtnOneItemChangeCart);
        })
