let boutton_camera = document.querySelector("#boutton-camera");
let camera = document.querySelector("#camera");
let boutton_photo = document.querySelector("#boutton-photo");
let photo = document.querySelector("#photo");
let nom_plante = document.querySelector("#nom_plante").textContent;
let ajax_path = $("#ajax-path").attr("ajax-path");
let boutton_upload = document.querySelector("#boutton-upload");
let boutton_reesayer = document.querySelector("#boutton-reesayer");
let photo_plante = document.querySelector("#photo-plante");
let cadre_feuille = document.querySelector("#cadre-feuille");
let boutton_revoir = document.querySelector("#boutton-revoir");
var latitude, longitude, date_photo, date_valide;

boutton_camera.addEventListener('click', async function () {
    let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
    camera.srcObject = stream;
    etape2();

});

function etape1(){
    boutton_camera.style.display = "unset";
    boutton_photo.style.display = "none";
    photo_plante.style.display = "unset";
    cadre_feuille.style.display = "none";
    boutton_revoir.style.display = "none";
}

function etape2(){
    boutton_camera.style.display = "none";
    boutton_photo.style.display = "unset";
    photo_plante.style.display = "none";
    cadre_feuille.style.display = "unset";
    boutton_revoir.style.display = "unset";
    boutton_upload.style.display = "none";
    boutton_reesayer.style.display = "none";
    photo.style.display = "none";
    camera.style.display = "unset";
}

function etape3(){
    boutton_upload.style.display = "unset";
    boutton_reesayer.style.display = "unset";
    photo.style.display = "unset";
    camera.style.display = "none";
    boutton_photo.style.display = "none";
    boutton_revoir.style.display = "none";
}

boutton_revoir.addEventListener('click', function () {
    etape1();
})

boutton_photo.addEventListener('click', function () {
    navigator.geolocation.getCurrentPosition((position) => {
        latitude = position.coords.latitude
        longitude = position.coords.longitude
    });
    const date = new Date();
    let jour = date.getDate();
    let mois = date.getMonth() + 1;
    let annee = date.getFullYear();
    date_photo = `${jour}-${mois}-${annee}`;
    etape3();
    photo.getContext('2d').drawImage(camera, 0, 0, photo.width, photo.height);
});

boutton_reesayer.addEventListener('click', function () {
    etape2();
})
// a retravailler 
function trouver() {
    let container_camera = document.querySelector("#container-camera");
    container_camera.style.display = "none";
    let div1 = document.querySelector("#div1");
    div1.style.display = "unset";
    const newDiv = document.createElement("p");
    const newContent = document.createTextNode(`Felicitation tu a ajouter le ${nom_plante} a ta collection`);
    newDiv.appendChild(newContent);
    newDiv.classList.add("en-tete");
    newDiv.classList.add("text-c");
    const currentDiv = document.getElementById("div1");
    currentDiv.classList.add("flex-col-around");
    currentDiv.insertBefore(newDiv, currentDiv.firstElementChild)
    setTimeout(function () { location.reload(true) }, 6000);
};


async function uploadFile() {
    var resizedCanvas = document.createElement("canvas");
    var resizedContext = resizedCanvas.getContext("2d");
    resizedCanvas.height = "300";
    resizedCanvas.width = "300";
    var canvas = document.getElementById("photo");
    resizedContext.drawImage(canvas, 0, 0, 300, 300);
    var image_url = resizedCanvas.toDataURL("image/webp", 0.99);
    const date = new Date();
    let jour = date.getDate();
    let mois = date.getMonth() + 1;
    let annee = date.getFullYear();
    date_valide = `${jour}-${mois}-${annee}`;
    console.log(nom_plante);
    $.ajax({
        url: ajax_path,
        data: {
            image_url: image_url, longitude: longitude, latitude: latitude,
            nom_plante: nom_plante, date_photo: date_photo, date_valide: date_valide
        },
        type: 'GET',
        success: trouver(),
    });
}