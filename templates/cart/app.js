function onClickBtnOneItemDeleteCart(event) {

    event.preventDefault();

    const url = this.href;
    const nbItemsSelected = this.querySelector('div.js-nbItemsSelected');
    const totalPriceByItem = this.querySelector('td.js-totalPriceByItem');
    const totalPriceItems = this.querySelector('td#js-totalPriceItems');

    axios.get(url, {responseType: 'json'})
        .then((response) => {
            console.log(response);
            console.log(response.data.nbItemsSelected);
            console.log(response.data.priceTotalByItem);
            console.log(response.data.priceTotalForAll);
        })
        .catch((error) => {
            window.alert("Réssayer plus tard");
        })
}

function onClickBtnOneItemAddCart(event) {

    event.preventDefault();

    const url = this.href;
    const nbItemsSelected = this.querySelector("div.js-nbItemsSelected");
    const totalPriceByItem = this.querySelector("td.js-totalPriceByItem");
    const totalPriceItems = this.querySelector("td#js-totalPriceItems");

    axios.get(url, {responseType: 'json'})
        .then((response) => {
            console.log(response);
            console.log(response.data.nbItemsSelected);
            console.log(response.data.priceTotalByItem);
            console.log(response.data.priceTotalForAll);
        })
        .catch((error) => {
            window.alert(error.message);
        })
}

document.querySelectorAll('a.js-minusNbItem').forEach(
    function (link) {
        link.addEventListener('click', onClickBtnOneItemDeleteCart);
    })

document.querySelectorAll('a.js-plusNbItem').forEach(
    function (link) {
        link.addEventListener('click', onClickBtnOneItemAddCart);
    })



