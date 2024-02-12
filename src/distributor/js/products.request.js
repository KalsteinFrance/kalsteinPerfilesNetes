/*let plugin_dir = 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/';
let domain = 'https://plataforma.kalstein.net/index.php/distributor/';*/


function validateProductData(name, brand, model, description, category, fileInput, stock, status,
    weight, length, width, height,
    weight_pa, length_pa, width_pa, height_pa, pa_type,
    price, currency,
    discount_1, discount_1_amount, discount_2, discount_2_amount, dont_image = false){


err_msg = '';

console.log((fileInput === undefined || fileInput === '' || fileInput == []))

// void verifications
if (name === '') {
err_msg = 'Nombre vacío';
}
else if (brand === '') {
    err_msg = 'Marca vacía';
}
else if (model === '') {
err_msg = 'Modelo vacío';
}
else if (description === '') {
err_msg = 'Descripción vacía';
}
else if (category === '') {
err_msg = 'Categoría vacía';
}
else if (stock === '') {
err_msg = 'Existencias vacío';
}
else if ((fileInput === undefined || fileInput === '' || fileInput == []) && !dont_image) {
    console.log(fileInput);
err_msg = 'Agrega una imágen o soluciona los problemas de la imágen actual';
}
else if (weight === '') {
err_msg = 'Peso vacío';
}
else if (width === '') {
err_msg = 'Ancho vacío';
}
else if (height === '') {
err_msg = 'Alto vacío';
}
else if (length === '') {
err_msg = 'Largo vacío';
}
else if (weight_pa === '') {
err_msg = 'Peso de empaque vacío';
}
else if (width_pa === '') {
err_msg = 'Ancho de empaque vacío';
}
else if (height_pa === '') {
err_msg = 'Alto de empaque vacío';
} 
else if (length_pa === '') {
err_msg = 'Largo de empaque vacío';
}
else if (pa_type === '') {
err_msg = 'Tipo de empaque vacío';
} 
else if (status === '') {
err_msg = 'Estatus vacío';
}
else if (price === '') {
err_msg = 'Precio unitario vacío';
}
else if (currency === '') {
err_msg = 'Tipo de moneda vacío';
}
// negative verification
else if (parseFloat(stock) <= 0) {
err_msg = 'Existencias no pueden ser menor que 0';
}
else if (parseFloat(price) <= 0) {
err_msg = 'Precio no puede ser menor que 0';
}
else if (parseFloat(weight) <= 0) {
err_msg = 'Peso no puede ser menor que 0';
}
else if (parseFloat(width) <= 0) {
err_msg = 'Largo no puede ser menor que 0';
}
else if (parseFloat(height) <= 0) {
err_msg = 'Ancho no puede ser menor que 0';
}
else if (parseFloat(length) <= 0) {
err_msg = 'Alto no puede ser menor que 0';
} 
else if (parseFloat(weight_pa) <= 0) {
err_msg = 'Peso de empaque no puede ser menor que 0';
}
else if (parseFloat(width_pa) <= 0) {
err_msg = 'Largo de empaque no puede ser menor que 0';
}
else if (parseFloat(height_pa) <= 0) {
err_msg = 'Ancho de empaque no puede ser menor que 0';
}
else if (parseFloat(length_pa) <= 0) {
err_msg = 'Alto de empaque no puede ser menor que 0';
}
// discount validations
else if (parseFloat(discount_1_amount) < 0) {
err_msg = 'Descuento 1 no puede ser menor de 0';
}
else if (parseFloat(discount_2_amount) < 0) {
err_msg = 'Descuento 2 no puede ser menor de 0';
}
else if (parseFloat(price) < 2){
err_msg = 'Precio no puede ser menor de 2';
}
// length validations
else if (name.length > 200) {
err_msg = 'Nombre debe tener menos de 200 carácteres';
}
else if (model.length > 50) {
err_msg = 'Modelo debe tener menos de 50 carácteres';
}
else if (description.length > 5000) {
err_msg = 'Descripción debe tener menos de 5000 carácteres';
}
else {


// verificacion de enlaces


let reg = RegExp(/(\b(https?|ftp|file):\/\/|www\.[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig)


let name_r = reg.test(name);
let description_r = reg.test(description);


if(name_r){
err_msg = 'Evite vincular a sitios web externos en el título';
}
else if(description_r){
err_msg = 'Evite vincular a sitios web externos en la descripción';
}


// verificacion de etiquetas HTML


reg_ex1 = RegExp(/<(\S*?)[^>]*>.*?<\/\1>|<.*?\/>/g);
reg_ex2 = RegExp(/<(\S*?)[^>]*>/g);


if (reg_ex1.test(description) || reg_ex2.test(description)){
err_msg = 'Evita usar expresiones de la forma "&lt;xxx&gt;", "&lt;xxx/&gt;".';
}


// marca y modelo en el nombre


let con1 = name.toLowerCase().includes(model.toLowerCase());
let con2 = name.toLowerCase().includes(document.querySelector('#brandProduct').value.toLowerCase());


if(con1){
err_msg = 'Por favor evite colocar el modelo en el nombre, complételo en el campo respectivo<br>';
}
else if(con2){
err_msg = 'Por favor evite colocar el nombre de su marca en el nombre de su producto<br>\
Su marca se completará con la información de su cuenta.';
}


// validacion de los descuentos


if (parseFloat(discount_1_amount) > 0){


if (discount_1 == '') {
err_msg = 'Descuento 1 vacío';
}
else if (parseFloat(discount_1) > 100) {
err_msg = 'El descuento 1 no puede ser mayor que 100';
}
else if (parseFloat(discount_1) <= 0) {
err_msg = 'El descuento 1 unidades no puede ser inferior a 0';
}


}


if (parseFloat(discount_2_amount) > 0){


if (discount_2 == '') {
err_msg = 'Descuento 2 vacío';
}
else if (parseFloat(discount_2) > 100) {
err_msg = 'El descuento 2 no puede ser mayor que 100';
}
else if (parseFloat(discount_2) <= 0) {
err_msg = 'El descuento de 2 unidades no puede ser inferior a 0';
}


}


// palabras clave


const words = [
   "Exclusivo",
   "barato",
   
   "Increíble",
   
   "Milagroso",
   
   "Garantizado",
   
   "Sin riesgo",
   
   "100% seguro",
   
   "Oferta limitada",
   
   "Ahorro garantizado",
   
   "Producto antiguo",
   
   "Solución definitiva",
   
   "Testimonios increíbles",
   
   "Secreto revelado",
   
   "Ganar dinero fácilmente",
   
   "Número 1 en ventas",
   
   "Precios de liquidación",
   
   "Descuentos exagerados",
   
   "Gana premios instantáneos",
   
   "Sin par",
   
   "Supera todas las expectativas",
];


for (let word of words){
if(description.includes(word)){
err_msg = 'se ha detectado una palabra inapropiada en la descripción: ' + word;
}
else if(name.includes(word)){
err_msg = 'se ha detectado una palabra inapropiada en el nombre: ' + word;
}
}
}


if (err_msg != ""){
iziToast.error({
title: 'Error',
message: err_msg,
position: 'center'
});
return false;
}
else return true;
}


function imgVal(file, id){


err_msg = '';


var maxSize = 10 * 1024 * 1024; // 10 MB
var allowedTypes = ['image/jpeg', 'image/png'];
var fileType = file.type;


if (file.size > maxSize) {
err_msg = 'El archivo excede el límite de 10 MB';
}
// formato de imagen
else if (!allowedTypes.includes(fileType)) {
err_msg = 'Sólo se permiten archivos JPG, PNG y JPEG.';
}


// tamaño mínimo
var _URL = window.URL || window.webkitURL;
var objectUrl = _URL.createObjectURL(file);


const image = document.createElement('img');


image.setAttribute('hidden', '');


if(err_msg == ""){
image.onload = function() {
if (image.width < 900 || image.height < 900) {


iziToast.error({
title: 'Error',
message: 'La imagen debe tener un tamaño mínimo de 900x900px',
position: 'center'
});


document.querySelector('#'+id).value = '';
}
}
}


image.src = objectUrl;
document.body.appendChild(image);


if (err_msg != ""){
iziToast.error({
title: 'Error',
message: err_msg,
position: 'center'
});
return false;
}
else return true;
}


function pdfVal(file){
if (file != undefined){


err_msg = '';


var maxSize = 20 * 1024 * 1024; // 20 MB
var allowedTypes = ['application/pdf'];
var fileType = file.type;


if (file.size > maxSize) {
err_msg = 'El tamaño del archivo supera el límite de 20 MB.';
}
// formato de imagen
else if (!allowedTypes.includes(fileType)) {
err_msg = 'Solo archivos PDF están permitidos';
}


if (err_msg != ""){
iziToast.error({
title: 'Error',
message: err_msg + ' El archivo será descartado',
position: 'center'
});
return false;
}
else return true;


}
}


jQuery(document).ready(function($) {


// SECCION: Envío de datos al servidor para añadir nuevo product


$(document).on('change', '#file-input', () => {
if (!imgVal($('#file-input')[0].files[0], 'file-input')){
$('#file-input').val(undefined);
}
});


$(document).on('change', '#manualPDF', () => {
if (!pdfVal($('#manualPDF')[0].files[0])){
$('#manualPDF').val(undefined);
}
});


$(document).on('change', '#catalogPDF', () => {
if (!pdfVal($('#catalogPDF')[0].files[0])){
$('#catalogPDF').val(undefined);
}
});

$(document).on('keydown', '#modelProduct', function(e) {
    if (e.which === 32) {
      e.preventDefault();
      
      iziToast.warning({
        title: 'Información',
        message: 'No está permitido el espaciado en este campo.',
        position: 'topCenter', 
        timeout: 3000
      });
    }
  });


$(document).on('click', '#btnSendData', function(e) {


var name = $('#nameProduct').val();
var brand = $('#brandProduct').val();
var model = $('#modelProduct').val();
var description = $('#descriptionProduct').val();
var category = $('#dataCategory').val();
var fileInput = $('#file-input')[0].files[0];
var stock = $('#stockProduct').val();
var status = $('#statusProduct').val();


if($('#table-mode').val() == 'basic'){
var longDescriptionCSV = csvFromBasicTable();
let json = CSVJSON.csv2json(longDescriptionCSV, {parseNumbers: true});
var longDescription = json2rawhtml(json, false);
}
else if($('#table-mode').val() == 'excel'){
var longDescriptionCSV = $('#csv').html();
let json = CSVJSON.csv2json(longDescriptionCSV, {parseNumbers: true});
var longDescription = json2rawhtml(json, document.querySelector('#has_headers').checked);
}
else {
var longDescriptionCSV = '';
var longDescription = '';
}


var weight = $('#weProduct').val();
var length = $('#leProduct').val();
var width = $('#wiProduct').val();
var height = $('#heProduct').val();


var weight_pa = $('#weProductPa').val();
var length_pa = $('#leProductPa').val();
var width_pa = $('#wiProductPa').val();
var height_pa = $('#heProductPa').val();
var pa_type = $('#packageType').val();


var price = $('#priceProduct').val();
var currency = $('#currency').val();


var discount_1 = $('#discount1').val();
var discount_1_amount = $('#discount1Amount').val();
var discount_2 = $('#discount2').val();
var discount_2_amount = $('#discount2Amount').val();


var manual = $('#manualPDF')[0].files[0];
var catalog = $('#catalogPDF')[0].files[0];


manual = manual == undefined? '' : manual;
catalog = catalog == undefined? '' : catalog;


if (validateProductData(name, brand, model, description, category, fileInput, stock, status,
weight, length, width, height,
weight_pa, length_pa, width_pa, height_pa, pa_type,
price, currency,
discount_1, discount_1_amount, discount_2, discount_2_amount)){


savedDataUpload(name, brand, model, description, category, fileInput, stock, status,
weight, length, width, height,
weight_pa, length_pa, width_pa, height_pa, pa_type,
price, currency,
discount_1, discount_1_amount, discount_2, discount_2_amount, manual, catalog,
longDescription, longDescriptionCSV);
}
});


function savedDataUpload(name, brand, model, description, category, fileInput, stock, status,
weight, length, width, height,
weight_pa, length_pa, width_pa, height_pa, pa_type,
price, currency,
discount_1, discount_1_amount, discount_2, discount_2_amount, manual, catalog,
longDescription, longDescriptionCSV) {


var formData = new FormData();


formData.append('name', name);
formData.append('brand', brand);
formData.append('model', model);
formData.append('description', description);
formData.append('category', category);
formData.append('fileName', fileInput);
formData.append('stock', stock);
formData.append('status', status);


formData.append('longDescription', longDescription);
console.log(longDescription)
formData.append('longDescriptionCSV', longDescriptionCSV);
console.log(longDescriptionCSV)

formData.append('we', weight);
formData.append('le', length);
formData.append('wi', width);
formData.append('he', height);

formData.append('we_pa', weight_pa);
formData.append('le_pa', length_pa);
formData.append('wi_pa', width_pa);
formData.append('he_pa', height_pa);
formData.append('pa_type', pa_type);

formData.append('price', price);
formData.append('currency', currency);

formData.append('discount_1', discount_1);
formData.append('discount_1_amount', discount_1_amount);
formData.append('discount_2', discount_2);
formData.append('discount_2_amount', discount_2_amount);

formData.append('manual', manual);
formData.append('catalog', catalog);

var all_accessories = [];
        
for (let elem of document.querySelector('#uploadAccesoryList').children){
    all_accessories.push(JSON.parse(elem.querySelector('textarea').value));
}
all_accessories = JSON.stringify(all_accessories)
console.log(all_accessories);
formData.append('accessoryData', all_accessories);
for (let key of Object.keys(currentFileAccessories)){
    formData.append('accessoryFiles-'+key, currentFileAccessories[key]);
}

$('#btnSendData').attr('disabled', '');
$.ajax({
contentType: "multipart/form-data",
url: plugin_dir + '/php/distributor/uploadProductData.php',
type: 'POST',
data: formData,
dataType: 'text',
processData: false,
contentType: false,
cache: false,
})
.done(function (response){
console.log(response);
if(!JSON.parse(response).err_msg){
iziToast.success({
title: 'Éxito',
message: 'Los datos se han subido correctamente',
position: 'center'
});
window.location.href = domain + '/productos';
}
else {
iziToast.error({
title: 'Error',
message: JSON.parse(response).err_msg,
position: 'center'
});
}

})
.fail(function (){
iziToast.error({
title: 'Error',
message: '¡Imposible conectarse con la base de datos!',
position: 'center'
});
});
}
});

jQuery(document).ready(function($) {

//SECCION: Subir datos para actualizar un producto existente
$(document).on('click', '#btnUpdateData', function(e) {
var id = $('#dataEdit').val();

var name = $('#nameProduct').val();
var brand = $('#brandProduct').val();
var model = $('#modelProduct').val();
var description = $('#descriptionProduct').val();
var category = $('#dataCategory').val();
var fileInput = $('#file-input')[0].files[0];
var stock = $('#stockProduct').val();
var status = $('#statusProduct').val();

if($('#table-mode').val() == 'basic'){
var longDescriptionCSV = csvFromBasicTable();
let json = CSVJSON.csv2json(longDescriptionCSV, {parseNumbers: true});

var longDescription = json2rawhtml(json, false);
}
else if($('#table-mode').val() == 'excel'){
var longDescriptionCSV = $('#csv').html();
let json = CSVJSON.csv2json(longDescriptionCSV, {parseNumbers: true});
var longDescription = json2rawhtml(json, document.querySelector('#has_headers').checked);
}
else {
var longDescriptionCSV = '';
var longDescription = '';
}

var weight = $('#weProduct').val();
var length = $('#leProduct').val();
var width = $('#wiProduct').val();
var height = $('#heProduct').val();

var weight_pa = $('#weProductPa').val();
var length_pa = $('#leProductPa').val();
var width_pa = $('#wiProductPa').val();
var height_pa = $('#heProductPa').val();
var pa_type = $('#packageType').val();

var price = $('#priceProduct').val();
var currency = $('#currency').val();

var discount_1 = $('#discount1').val();
var discount_1_amount = $('#discount1Amount').val();
var discount_2 = $('#discount2').val();
var discount_2_amount = $('#discount2Amount').val();;

dont_image = fileInput == null;

var manual = $('#manualPDF')[0].files[0];
var catalog = $('#catalogPDF')[0].files[0];

manual = manual == undefined? '' : manual;
catalog = catalog == undefined? '' : catalog;

if (validateProductData(name, brand, model, description, category, fileInput, stock, status,
weight, length, width, height,
weight_pa, length_pa, width_pa, height_pa, pa_type,
price, currency,
discount_1, discount_1_amount, discount_2, discount_2_amount, dont_image)){

iziToast.question({
title: 'Confirmación',
message: '¿Estás seguro de que deseas editar el producto?',
position: 'center',
buttons: [
['<button><b>Sí</b></button>', function (instance, toast) {
instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

updateDataUpload(id, name, brand, model, description, category, fileInput, stock, status,
weight, length, width, height,
weight_pa, length_pa, width_pa, height_pa, pa_type,
price, currency,
discount_1, discount_1_amount, discount_2, discount_2_amount, manual, catalog,
longDescription, longDescriptionCSV);
},
true], 
['<button>No</button>', function (instance, toast) {
instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
}]
]
});
}
});

function updateDataUpload(id, name, brand, model, description, category, fileInput, stock, status,
weight, length, width, height,
weight_pa, length_pa, width_pa, height_pa, pa_type,
price, currency,
discount_1, discount_1_amount, discount_2, discount_2_amount, manual, catalog,
longDescription, longDescriptionCSV) {

var formData = new FormData();

formData.append('id', id);

formData.append('name', name);
formData.append('brand', brand);
formData.append('model', model);
formData.append('description', description);
formData.append('category', category);
formData.append('fileName', fileInput);
formData.append('stock', stock);
formData.append('status', status);

formData.append('longDescription', longDescription);
console.log(longDescription);
formData.append('longDescriptionCSV', longDescriptionCSV);
console.log(longDescriptionCSV);
formData.append('we', weight);
formData.append('le', length);
formData.append('wi', width);
formData.append('he', height);

formData.append('we_pa', weight_pa);
formData.append('le_pa', length_pa);
formData.append('wi_pa', width_pa);
formData.append('he_pa', height_pa);
formData.append('pa_type', pa_type);

formData.append('price', price);
formData.append('currency', currency);

formData.append('discount_1', discount_1);
formData.append('discount_1_amount', discount_1_amount);
formData.append('discount_2', discount_2);
formData.append('discount_2_amount', discount_2_amount);

formData.append('manual', manual);
formData.append('catalog', catalog);

if(manual) {
formData.append('manual', manual);
}
else{
formData.append('dontUpdatePDF', true);
}

if(manual) {
formData.append('manual', manual);
}
else{
formData.append('dontUpdateCatalogPDF', true);
}

if (fileInput) {
formData.append('fileName', fileInput);
}
else{
formData.append('dontUpdateImg', true);
}
var all_accessories = [];
        
for (let elem of document.querySelector('#uploadAccesoryList').children){
    all_accessories.push(JSON.parse(elem.querySelector('textarea').value));
}
all_accessories = JSON.stringify(all_accessories)
formData.append('accessoryData', all_accessories);
for (let key of Object.keys(currentFileAccessories)){
    formData.append('accessoryFiles-'+key, currentFileAccessories[key]);
}
$('#btnUpdateData').attr('disabled', '');

$.ajax({
contentType: "multipart/form-data",
url: plugin_dir + '/php/distributor/updateProductData.php',
type: 'POST',
data: formData,
dataType: 'text',
processData: false,
contentType: false,
cache: false,
})
.done(function (response){
console.log(response);
if(!JSON.parse(response).err_msg){
iziToast.success({
title: 'Éxito',
message: 'Los datos se han actualizado correctamente',
position: 'center'
});
window.location.href = domain + '/productos';
}
else {
iziToast.error({
title: 'Error',
message: JSON.parse(response).err_msg,
position: 'center'
});
}

})
.fail(function (){
iziToast.error({
title: 'Error',
message: '¡imposible conectar con la base de datos!',
position: 'center'
});
});
}
});


jQuery(document).ready(function($){

// SECCION: Eliminar producto desde el boton de la página

$(document).on('click', '#btnDeleteProduct', function(){
let delete_aid = $(this).val();

iziToast.question({
title: 'Confirmación',
message: '¿Estás seguro que deseas eliminar este producto?',
close: false,
overlay: true,
timeout: false,
position: 'center',
buttons: [
['<button><b>Sí</b></button>', function (instance, toast) {

$.ajax({
url: plugin_dir + '/php/manufacturer/deleteProduct.php',
type: 'POST',
data: {delete_aid}
})
.done(function(response){
console.log(response);
if(response == 'done'){
// muestra el iziToast
instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
iziToast.success({
   title: 'Éxito',
   message: 'Producto eliminado.',
   position: 'center'
});

// elimina el elemento html de la tabla
$("#product-" + delete_aid).remove();

// si la tabla se vacía, muestra el mensaje de que no hay datos en stock
if(document.querySelector("#product-table-body").children.length == 0){
   $("#missing-data-msg").html("<!--center><span class='material-symbols-rounded  icon'>sentiment_dissatisfied</span></center--><center><p style='color: #000;'>You don't have any product on stock</p></center>");
}
}
// error al borrar el registro
else {
instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
iziToast.error({
   title: 'Error',
   message: 'Product no eliminado',
   position: 'center'
});
}
})
// error al conectar con el archivo
.fail(function(){
instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
iziToast.error({
title: 'Error',
message: "No se puede conectar con la base de datos",
position: 'center'
});
});

},
true],
['<button>No</button>', function (instance, toast) {
instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
iziToast.error({
title: 'Error',
message: 'Eliminación de producto cancelado',
position: 'center'
});
}]
]
});
});

// BOTON QUE LLEVA A LA PAGINA PARA EDITAR EL FORMULARIO

$(document).on('click', '#btnEditProduct', function (){
let edit_id = $(this).val();


console.log('detectó');


let form = $("<form action='" + domain + "/productos/editar" + "' method='get' hidden>" +
"<input type='hidden' name='edit' value='" + edit_id + "' /></form>");


$('body').append(form);
form.submit();
});
});



jQuery(document).ready(function($){


// SECCIÓN: Preisualizar imagen del producto desde la tabla de stock


$(document).on('click', '#btnView', function(){
let image = $(this).val();
showImage(image);
});


function showImage(image) {
iziToast.show({
title: '',
message: '<img src="'+image+'" style="max-width: 400px; max-height: 400px; width: auto; height: auto; display: block; margin: 0 auto;">',
close: true,
imageAlt: 'Image',
onClosing: function(instance, toast, closedBy){
}
});
}
});


jQuery(document).ready(function($){


// SECCIÓN: cambiar el estatus de un pedido


$(document).on('click', '#btnUpdate', function(){
var id = $(this).val();
var selectedStatus = $(this).siblings('.status-select').val();
var customerName = $(this).closest('tr').find('.customer-name').text();


if (selectedStatus != ''){


iziToast.question({
timeout: false,
close: false,
overlay: true,
displayMode: 'once',
id: 'question',
zindex: 999,
title: 'Confirmación',
message: '¿Estás seguro que deseas cambiar el estatus para ' + customerName + '?',
position: 'center',
buttons: [
['<button><b>Sí</b></button>', function(instance, toast) {
instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
quoteUpdateStatus(id, selectedStatus, customerName);
}, true],
['<button>No</button>', function(instance, toast) {
instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
}]
],
onClosing: function(instance, toast, closedBy) {
console.log('Closing...');
},
onClosed: function(instance, toast, closedBy) {
console.log('Closed...');
}
});
}
else{
iziToast.warning({
title: 'Advertencia',
message: '¡Por favor, selecciona una opción!',
position: 'topRight',
});
}
});


function quoteUpdateStatus(cotizacion_id, cotizacion_status, customerName) {
$.ajax({
url: plugin_dir + '/php/distributor/updateStatus.php',
method: 'POST', 
data: {cotizacion_id, cotizacion_status}
})
.done(function(respuesta){
let data = JSON.parse(respuesta)
if (data.update === 'correcto'){
iziToast.success({
title: 'Éxito',
message: '¡Actualización correcta!',
position: 'topRight',
});
window.location.href = domain + '/ordenes/?i=' + $('#hiddenPage').val();
}
})
.fail(function(){
console.log("error");
});
}
});


jQuery(document).ready(function($){
$('.circulatorDiv').hover(
function(){
$(this).css({'cursor' : 'pointer'})
$(this).children('.div01').animate({"left": "-100%"}, "slow");
$(this).children('.div02').animate({"right": "0"}, "slow");
}, function(){       
$(this).children('.div01').animate({"left": "0"}, "slow");
$(this).children('.div02').animate({"right": "-100%"}, "slow");
}
)
});


jQuery(document).ready(function($) {
$(document).on('click', '#btnSendDataShipping', function (){


let country = $('#country-select').val();


let aerial_weigth = $('#country-aerial-weigth').val();
let aerial_price = $('#country-aerial-price').val();
let maritimal = $('#country-maritimal').val();


let err_msg = '';


if (country == '') {
err_msg = 'Country empty';
}
else if (aerial_weigth == '') {
err_msg = 'Aerial weigth empty';
}
else if (aerial_price == '') {
err_msg = 'Aerial price empty';
}
else if (maritimal == '') {
err_msg = 'Maritimal price empty';
}
// negative verification
else if (parseFloat(aerial_weigth) <= 0) {
err_msg = 'Aerial weigth cannot be less than 0';
}
else if (parseFloat(aerial_price) <= 0) {
err_msg = 'Aerial price cannot be less than 0';
}
else if (parseFloat(maritimal) <= 0) {
err_msg = 'Maritimal cannot be less than 0';
}
console.log(err_msg);
if (err_msg == ''){


var formData = new FormData();


formData.append('country', country);
formData.append('aerial_we', aerial_weigth);
formData.append('aerial_pr', aerial_price);
formData.append('maritimal_pr', maritimal);


$.ajax({
contentType: "multipart/form-data",
url: plugin_dir + '/php/distributor/uploadShippingPrices.php',
type: 'POST',
data: formData,
dataType: 'text',
processData: false,
contentType: false,
cache: false,
})
.done(function (response){
console.log(response);
if(!JSON.parse(response).err_msg){
iziToast.success({
title: 'Success',
message: 'The data has been successfully uploaded.',
position: 'center'
});
}
else {
iziToast.error({
title: 'Error',
message: JSON.parse(response).err_msg,
position: 'center'
});
}


})
.fail(function (){
iziToast.error({
title: 'Error',
message: 'Unable to connect whit the database!',
position: 'center'
});
});
}
else {
iziToast.error({
title: 'Error',
message: err_msg,
position: 'center'
});
}
});
});

jQuery(document).ready(function($){
    $(document).on('keydown', '#modelProduct', function(e){
        if (e.which === 32) {
            e.preventDefault();
          }        
    });
});


jQuery(document).ready(function($){
    function keepSessionAlive() {
        $.ajax({
            url: plugin_dir + '/php/nameQuerySession.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log("name: " + data.nameQuery);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error getting name of session: " + textStatus + ", " + errorThrown);
            }
        });
    }

    var intervalMinutes = 5;
    setInterval(keepSessionAlive, intervalMinutes * 60 * 1000);
});
