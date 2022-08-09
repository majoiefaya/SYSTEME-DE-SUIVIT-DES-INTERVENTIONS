let mymap,marqueur // Variable qui permettra de stocker la carte

// On attend que le DOM soit chargé
window.onload = () => {
    // Nous initialisons la carte et nous la centrons sur Paris
    mymap = L.map('detailsMap').setView([6.130419, 1.215829], 11)
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: 'SDI',
        minZoom: 1,
        maxZoom: 20
    }).addTo(mymap)
    mymap.on("click",mapClickListen)
    document.querySelector("#ville").addEventListener("blur",getCity)
}

function mapClickListen(e){
    ///Recuperation des Coorconnées du Click/
    let pos=e.latlng
    console.log(e)

    addMarker(pos)

    ///Affichage dans le formulaire
    document.querySelector("#lat").value=pos.lat
    document.querySelector("#lon").value=pos.lng
}

function addMarker(pos){
    //verifier si un marqueur existe
    if(marqueur!=undefined){
        mymap.removeLayer(marqueur)
    }
    marqueur=L.marker(pos,{
        //on rend Le Marqueur Deplaceable
        draggable:true
    })

    //On ecoute le glisser/deposer sur le marqueur
    marqueur.on("dragend",function(e){
        pos=e.target.getLatLng()
        document.querySelector("#lat").value=pos.lat
        document.querySelector("#lon").value=pos.lng
    })
    marqueur.addTo(mymap)
}

function getCity(){
     // On "fabrique" l'adresse complète (des vérifications préalables seront nécessaires)
     let adresse = document.querySelector("#adresse").value + ", " + document.querySelector("#cp").value+ " " + document.querySelector("#ville").value

     // On initialise la requête Ajax
     const xmlhttp = new XMLHttpRequest
 
     // On détecte les changements d'état de la requête
     xmlhttp.onreadystatechange = () => {
         // Si la requête est terminée
         if(xmlhttp.readyState == 4){
             // Si nous avons une réponse
             if(xmlhttp.status == 200){
                 // On récupère la réponse
                 let response = JSON.parse(xmlhttp.response)

                 console.log(response)

                 let lat=response[0]["lat"]
                 let lon=response[0]["lon"]

                 document.querySelector("#lat").value=lat
                 document.querySelector("#lon").value=lon
                 
                 let pos=[lat,lon]
                 addMarker(pos)

                 mymap.setView(pos,10)
                 
                
             }
         }
     }
 
     // On ouvre la requête
     xmlhttp.open('get', `https://nominatim.openstreetmap.org/search?q=${adresse}&format=json&addressdetails=1&limit=1&polygon_svg=1`)
 
     // On envoie la requête
     xmlhttp.send();
}