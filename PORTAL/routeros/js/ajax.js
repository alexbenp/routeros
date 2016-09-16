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


function deleteInfo(id,url_destino,origen,resultado,action){
	//donde se mostrará el resultado de la eliminacion
	// alert(url_destino);
	divResultado = document.getElementById('resultado');
	action		 = document.getElementById(action).value;
	divOrigen	 = document.getElementById('tr'+id);
	//usaremos un cuadro de confirmacion	
	var eliminar = confirm("Confirma Eliminar el Registro?")
	if ( eliminar ) {
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod GET
		//indicamos el archivo que realizará el proceso de eliminación
		//junto con un valor que representa el id del empleado
		ajax.open("GET", url_destino+"?id="+id+"&action="+action);
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


function sendInfo(id,url_destino,origen,resultado,action){
	//donde se mostrará el resultado de la eliminacion
	// alert(url_destino);
	divResultado = document.getElementById(resultado);
	action		 = document.getElementById(action).value;
	divOrigen	 = document.getElementById(origen+id);
	var eliminar = confirm("Confirma Activar el Router?")
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod GET
		//indicamos el archivo que realizará el proceso de eliminación
		//junto con un valor que representa el id del empleado
		ajax.open("POST", url_destino+"?router_id="+id+"&action="+action);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				//mostrar resultados en esta capa
				divResultado.innerHTML = ajax.responseText
			}
		}
		//como hacemos uso del metodo GET
		//colocamos null
		ajax.send(null)
}




