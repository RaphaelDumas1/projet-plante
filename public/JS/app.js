let boutton_camera = document.querySelector("#boutton-camera");
let camera = document.querySelector("#camera");
let boutton_photo = document.querySelector("#boutton-photo");
let photo = document.querySelector("#photo");
let nom_plante = document.querySelector("#nom_plante").textContent;
let ajax_path = $("#ajax-path").attr("ajax-path");
let boutton_upload = document.querySelector("#boutton-upload");
var latitude, longitude, date_photo, date_valide;

boutton_camera.addEventListener('click', async function () {
    let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
    camera.srcObject = stream;
    boutton_camera.style.display = "none";
    boutton_photo.style.display = "unset";
});


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
    boutton_upload.style.display = "unset";
    photo.getContext('2d').drawImage(camera, 0, 0, photo.width, photo.height);
});

// a retravailler 
function trouver() {
    let div2 = document.querySelector("#div2");
    div2.style.display = "none";
    const newDiv = document.createElement("div");
    const newContent = document.createTextNode(`Felicitation tu a ajouter le ${nom_plante} a ta collection`);
    newDiv.appendChild(newContent);
    newDiv.classList.add("texte");
    newDiv.classList.add("en-tete");
    const currentDiv = document.getElementById("div1");
    document.body.insertBefore(newDiv, currentDiv);
    setTimeout(location.reload(true), 6000);
};


async function uploadFile() {
    let image_url = document.querySelector("#photo").toDataURL("image/webp");
    const date = new Date();
    let jour = date.getDate();
    let mois = date.getMonth() + 1;
    let annee = date.getFullYear();
    date_valide = `${jour}-${mois}-${annee}`;
    $.ajax({
        url: ajax_path, 
        data: {
            image_url : image_url, longitude: longitude, latitude: latitude,
            nom_plante: nom_plante, date_photo: date_photo, date_valide: date_valide
        },
        type: 'GET',
        success: trouver(),
    });
}