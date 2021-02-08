class LeafletMap {

    #map;
    #bounds;

    constructor() {
        this.#map = null;
        this.#bounds = [];
    }

    // On charge la carte dans l'élément sélectionné de façon asynchrone. On ajoute donc resolve et reject
    load(element){
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

    addMarker(lat, lng, text){
        let point = [lat, lng]
        this.bounds.push(point);
        return new LeafletMarker(point, text, this.map);
    }

    cartCenter(){
        this.map.fitBounds(this.bounds);
    }
}