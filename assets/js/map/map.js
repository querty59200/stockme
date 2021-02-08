import '../../css/map/map.css';

import L from 'leaflet'
var slugify = require('slugify')

let $map = document.querySelector('#mapid');

class LeafletMap {

    constructor() {
        this.map = null;
        this.bounds = [];
    }

    // On charge la carte dans l'élément sélectionné de façon asynchrone. On ajoute donc resolve et reject
    async load(element){
        return new Promise(((resolve, reject) => {
            // Créer la carte
            this.map = L.map(element).setView([47, 3.8], 7);

            // Poser les tuiles d'openStreetMap et les ajouter à la carte
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 15,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1
            }).addTo(this.map);
            resolve();
        }))
    }

    addPopUp(lat, lng, text, id ){
        let point = [lat, lng]
        this.bounds.push(point);
        return new LeafletPopUp(point, text, id, this.map);
    }

    cartCenter(){
        this.map.fitBounds(this.bounds);
    }
}

class LeafletPopUp {

    constructor(point, text, id, map) {
        this.popup = L.marker(point,{
            autoClose : false,
            closeOnEscapeKey : false,
            closeOnClick : false,
            closeButton : false,
            className : 'marker',
            maxWidth : 400,
        })
            // .setLatLng(point)
            // .setContent(text)
cdcd            .bindPopup("<a href=\"" + slugify(text, {remove: /[*+~.()'"!:@]/g}).toLowerCase() + "-" + id + "\/show\">Détail</a>")
            .addTo(map)
    }

    setActive(){
        this.popup.getElement().classList.add('is-active');
    }

    unsetActive(){
        this.popup.getElement().classList.remove('is-active');
    }

    openInfo(event, cb){
        this.popup.addEventListener('add', () => {
            this.popup.getElement().addEventListener(event, cb);
        })
    }

    setContent(text){
        this.popup.setContent(text).update();
    }
}

const initMap = async function () {
    // On instancie une carte tuilé avec OpenStreeMap
    let map = new LeafletMap()
    let hoverPopUp = null;
    await map.load($map)
    // On stocke dans un tableau tous les marqueurs possédant les informations
    // lat, lng et price de la DB (cf les "data-*) auxquels on associe la méthode addMarker
    Array.from(document.querySelectorAll('.js-marker')).forEach((item) => {

        let popup = map.addPopUp(item.dataset.lat, item.dataset.lng, item.dataset.name, item.dataset.id)

        item.addEventListener('mouseover', function () {
            if(hoverPopUp !== null){
                hoverPopUp.unsetActive()
            }
            popup.setActive();
            hoverPopUp = popup;
        })

        item.addEventListener('mouseleave', function (){
            if(hoverPopUp !== null){
                hoverPopUp.unsetActive()
            }
        })

        popup.openInfo('onclick', function (){
            console.log('hello')
            // marker.setContent(item.innerHTML);
        })
    })
    // Centrer la carte en fct des markers
    map.cartCenter();
}

if($map !== null){
    // Initialisation de la carte
    initMap()
}