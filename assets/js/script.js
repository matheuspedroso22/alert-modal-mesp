var modal = document.getElementById('alert-modal-mesp');
var close = document.querySelector("#alert-modal-mesp .close");
modal.style.display = "block";

window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}