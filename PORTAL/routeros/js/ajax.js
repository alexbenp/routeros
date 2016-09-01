function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function eliminarDato(id){
	//donde se mostrar� el resultado de la eliminacion
	divResultado = document.getElementById('resultado');
	divOrigen	 = document.getElementById('tr'+id);
	//usaremos un cuadro de confirmacion	
	var eliminar = confirm("Confirma Eliminar el Registro?")
	if ( eliminar ) {
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod GET
		//indicamos el archivo que realizar� el proceso de eliminaci�n
		//junto con un valor que representa el id del empleado
		ajax.open("GET", "elimina_dato_router.php?id="+id);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				//mostrar resultados en esta capa
				divResultado.innerHTML = ajax.responseText
				divOrigen.innerHTML = "";
				
			}
		}
		//como hacemos uso del metodo GET
		//colocamos null
		ajax.send(null)
	}
}