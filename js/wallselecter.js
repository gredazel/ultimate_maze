var w, h, previewtable;
window.onload = function() {
	var tabelladeimuri = document.getElementsByClassName("walls-table")[0];
	// tabelladeimuri contiene la tabella... dei muri... si...
	var rows = tabelladeimuri.getElementsByTagName("tr");
	//in rows metto tutte le <tr> presenti nella tabelladeimuri
	h = rows.length;
	//metto in h la rows.length perché così so quante righe sono presenti
	w = rows[0].childElementCount;
	// in w la larghezza della tabella (le righe sono tutte larghe uguali)
	for (var i = 0; i < h; i++) {
		for (var j = 0; j < w; j++) { //solito ciclo in stile matrice
			if (!rows[i].children[j].classList.contains("targetcell") && !rows[i].children[j].classList.contains("isacell") && !rows[i].children[j].classList.contains("unselectable")) {
				//applico l'ascoltatore "onclick" solo alle celle che non sono né angoli, né camminabili, né arrivo o fine
				rows[i].children[j].onclick = function(e) {
					var rc = parseInt(e.target.attributes['riga'].value);
					var cc = parseInt(e.target.attributes['colonna'].value);
					if (e.target.classList.contains("selected")) { //l'ascoltatore, se attivato, fa partire un algoritmo per stabilire che muro si sta mettendo
						if (rc % 2 == 0) { //e va ad aggiornare la select di conseguenza, le option si aggiornano così per essere mandate in post
							//da mettere bordo destro alla cella subito a sinsitra
							document.getElementById((rc)/2+"_"+((cc-1)/2)).classList.remove("bdestra");
							var precval = parseInt(document.getElementById("opt_"+(rc)/2+"_"+((cc-1)/2)).value);
							document.getElementById("opt_"+(rc)/2+"_"+((cc-1)/2)).value = precval - 2; //ogni muro viene attivato per due celle ovviamente
							//e bordo sinistro alla cella subito a destra
							var precval = parseInt(document.getElementById("opt_"+(rc)/2+"_"+((cc+1)/2)).value);
							document.getElementById("opt_"+(rc)/2+"_"+((cc+1)/2)).value = precval - 8;
						} else {
							//da mettere bordo sotto alla cella subito sopra
							document.getElementById((rc-1)/2+"_"+(cc/2)).classList.remove("bsotto");
							var precval = parseInt(document.getElementById("opt_"+(rc-1)/2+"_"+(cc/2)).value);
							document.getElementById("opt_"+(rc-1)/2+"_"+(cc/2)).value = precval - 4;
							var precval = parseInt(document.getElementById("opt_"+(rc+1)/2+"_"+(cc/2)).value);
							document.getElementById("opt_"+(rc+1)/2+"_"+(cc/2)).value = precval - 1;
						}
						e.target.classList.remove("selected");
					} else {
						if (rc % 2 == 0) {
							//da mettere bordo destro alla cella subito a sinsitra
							document.getElementById((rc)/2+"_"+((cc-1)/2)).classList.add("bdestra");
							var precval = parseInt(document.getElementById("opt_"+(rc)/2+"_"+((cc-1)/2)).value);
							document.getElementById("opt_"+(rc)/2+"_"+((cc-1)/2)).value = precval + 2;
							var precval = parseInt(document.getElementById("opt_"+(rc)/2+"_"+((cc+1)/2)).value);
							document.getElementById("opt_"+(rc)/2+"_"+((cc+1)/2)).value = precval + 8;
						} else {
							//da mettere bordo sotto alla cella subito sopra
							document.getElementById((rc-1)/2+"_"+(cc/2)).classList.add("bsotto");
							var precval = parseInt(document.getElementById("opt_"+(rc-1)/2+"_"+(cc/2)).value);
							document.getElementById("opt_"+(rc-1)/2+"_"+(cc/2)).value = precval + 4;
							var precval = parseInt(document.getElementById("opt_"+(rc+1)/2+"_"+(cc/2)).value);
							document.getElementById("opt_"+(rc+1)/2+"_"+(cc/2)).value = precval + 1;
						}
						e.target.classList.add("selected");
					}
				}
			}
		}
	}
}
function randomize () { //funzione per non mettere io tutti i muri ogni volta
	var tzz = document.getElementsByClassName("walls-table")[0].getElementsByTagName("td");
	for (var kn in tzz) {
		if (kn < tzz.length) {
			if(parseInt(Math.random() * 100) > 30) {
				tzz[kn].click();
			}
		}
	}
}
