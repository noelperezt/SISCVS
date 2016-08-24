(function() {
    if ($.browser.msie && $.browser.version.substr(0,1)<7){
        $('li').has('ul').mouseover(function(){
        $(this).children('ul').css('visibility','visible');
        }).mouseout(function(){
         $(this).children('ul').css('visibility','hidden');
        })
    }
});
			
function reloj() {
    var fecha = new Date();
    var hora = fecha.getHours();
    var min = fecha.getMinutes();
    var seg = fecha.getSeconds();
        if (hora>=12)
            jornada = ' PM'
        else
            jornada = ' AM'
        if (hora>12)
            hora -=12;
        if(hora<10)
            hora = '0'+hora;
        if(min<10)
            min = '0'+min;
        if(seg<10)
            seg = '0'+seg;
        var recarga = setTimeout("reloj()", 1000);
        document.getElementById('reloj').innerHTML = hora + ":" + min + ":" + seg + jornada;
}

function fecha(){ 
	var d = new Date() 
	var cadena; 
	mdia= d.getDate(); 
	mdiaw= d.getDay(); 
	mmes = d.getMonth(); 
	anyo = d.getFullYear(); 
	mes= new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"); 
	dia= new Array("Domingo","Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"); 
	var recarga = setTimeout("fecha()", 1000);
	document.getElementById('fecha').innerHTML = dia[mdiaw] + ", " + mdia + " de " + mes[mmes] + " de " + anyo; 
} 

(function(document) {
  'use strict';

  var LightTableFilter = (function(Arr) {

    var _input;

    function _onInputEvent(e) {
      _input = e.target;
      var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
      Arr.forEach.call(tables, function(table) {
        Arr.forEach.call(table.tBodies, function(tbody) {
          Arr.forEach.call(tbody.rows, _filter);
        });
      });
    }

    function _filter(row) {
      var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
      row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
    }

    return {
      init: function() {
        var inputs = document.getElementsByClassName('light-table-filter');
        Arr.forEach.call(inputs, function(input) {
          input.oninput = _onInputEvent;
        });
      }
    };
  })(Array.prototype);

  document.addEventListener('readystatechange', function() {
    if (document.readyState === 'complete') {
      LightTableFilter.init();
    }
	
  });

})(document);

function isNumber(e) {
k = (document.all) ? e.keyCode : e.which;
if (k==8 || k==0) return true;
patron = /\W/;
n = String.fromCharCode(k);
return patron.test(n);
}

function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        status = "This field accepts numbers only."
        return false
    }
    status = ""
    return true
}

			