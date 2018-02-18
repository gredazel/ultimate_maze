function build_destroy(elemento) {
	// funzione per rimuovere e mettere la classe "collassato" (che altro non è che un display: none
	if (elemento.classList.contains("collassato")) {
		elemento.classList.remove("collassato");
	} else {
		elemento.classList.add("collassato");
	}
}
