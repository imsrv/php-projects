function datosServidor() {
};
datosServidor.prototype.iniciar = function() {
	try {
		this._xh = new XMLHttpRequest();
	} catch (e) {
		var _ieModelos = new Array(
		'MSXML2.XMLHTTP.5.0',
		'MSXML2.XMLHTTP.4.0',
		'MSXML2.XMLHTTP.3.0',
		'MSXML2.XMLHTTP',
		'Microsoft.XMLHTTP'
		);
		var success = false;
		for (var i=0;i < _ieModelos.length && !success; i++) {
			try {
				this._xh = new ActiveXObject(_ieModelos[i]);
				success = true;
			} catch (e) {
			
			}
		}
		if ( !success ) {
			return false;
		}
		return true;
	}
}

datosServidor.prototype.ocupado = function() {
	estadoActual = this._xh.readyState;
	return (estadoActual && (estadoActual < 4));
}

datosServidor.prototype.procesa = function() {
	if (this._xh.readyState == 4 && this._xh.status == 200) {
		this.procesado = true;
	}
}

datosServidor.prototype.enviar = function(urlget,datos) {
	if (!this._xh) {
		this.iniciar();
	}
	if (!this.ocupado()) {
		this._xh.open("GET",urlget,false);
		this._xh.send(datos);
		if (this._xh.readyState == 4 && this._xh.status == 200) {
			return this._xh.responseText;
		}
		
	}
	return false;
}
function _gr(reqseccion,divcont) {
	remotos = new datosServidor;
	nt = remotos.enviar(reqseccion,"");
	document.getElementById(divcont).innerHTML = nt;
}
var urlBase = "/oyver.php?";
function rateImg(rating,imgId)  {
		remotos = new datosServidor;
		nt = remotos.enviar('/oyver.php?rating='+rating+'&videoid='+imgId);
		rating = rating * 25;
		document.getElementById('current-rating').style.width = rating+'px';
}