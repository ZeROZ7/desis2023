//FUNCIONES AUXILIARES DE VALIDACION
var Fn = {	
	validaRut: function (rutCompleto) {
		if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
			return false;
		var tmp 	= rutCompleto.split('-');
		var digv	= tmp[1]; 
		var rut 	= tmp[0];
		if ( digv == 'K' ) digv = 'k' ;
		return (Fn.dv(rut) == digv );
	},
	dv: function(T){
		var M=0,S=1;
		for(;T;T=Math.floor(T/10))
			S=(S+T%10*(9-M++%6))%11;
		return S?S-1:'k';
	},
    contieneNumero: function(str) {
        return /\d/.test(str);
    },    
    contieneLetras: function(str) {
        return /[a-zA-Z]/g.test(str);
    }
}
//ACCIONES FORMULARIO    
    function salvarFn(){
        //VALIDACIONES
        if ($("#nombre").val().trim().length == 0){
        alert("Campo nombre no puede quedar en blanco");
        return; 
        }
        if ( !(Fn.contieneNumero($("#alias").val()) && Fn.contieneLetras($("#alias").val())) ){
        alert("Campo Alias debe contener al menos 1 numero y 1 letra");
        return; 
        }
        if (!Fn.validaRut( $("#rut").val().split('.').join(""))){
            alert("RUT Invalido");
            return;
        }   
        let fuentesArray = [];
        $('.fuentes:checked').each(function(i){
            fuentesArray[i] = $(this).val();
        });
        if (fuentesArray.length < 2){
            alert("Debe seleccionar almenos 2 opciones de como se entero de nosotros");
            return;
        }
        $.post("controller/votacion.php",
        {
            nombre: $("#nombre").val(),
            alias: $("#alias").val(),
            rut: $("#rut").val(),
            email: $("#email").val(),
            region: $("#region").val(),
            comuna: $("#comuna").val(),
            candidato: $("#candidatos").val(),
            fuentes: fuentesArray
        },
        function(data, status){
            alert(data);
            location.reload()          
        });
    }

//LISTADOS
    function regionesFn(){
        $.get("controller/regiones.php", function(data, status){
            if (status == 'success'){        
                let regionArray = JSON.parse(data);
                regionArray.forEach(element => {                
                    $("#region").append("<option value=" + element.id + ">" + element.nombre + "</option>");
                });
            }else{
                warning("Ha ocurrido un error");
            }   
        });
    }
    function comunasFn(region_id){
        $.get("controller/comunas.php?region_id="+region_id, function(data, status){
            if (status == 'success'){        
                let comunaArray = JSON.parse(data);
                $('#comuna')
                    .find('option')
                    .remove(); 
                $("#comuna").append('<option disabled selected value>Selecciona Comuna</option>');
                comunaArray.forEach(element => {                
                    $("#comuna").append("<option value=" + element.id + ">" + element.nombre + "</option>");                
                });
            }else{
                warning("Ha ocurrido un error");
            }   
        });
    }
    function candidatosFn(){
        $.get("controller/candidatos.php", function(data, status){
            if (status == 'success'){        
                let candidatoArray = JSON.parse(data);
                candidatoArray.forEach(element => {                          
                    $("#candidatos").append("<option value=" + element.id + ">" + element.nombre + "</option>");
                });
            }else{
                alert("Ha ocurrido un error");
            }   
        });
    }
    function fuentesFn(){
        $.get("controller/fuentes.php", function(data, status){
            if (status == 'success'){        
                let fuentesArray = JSON.parse(data);
                fuentesArray.forEach(element => {                          
                    $("#fuente").append(" <input type='checkbox' class='fuentes' name='fuentes[]' value='"+element.id+"'>"+element.nombre+"     ");
                });
            }else{
                alert("Ha ocurrido un error");
            }   
        });
    }

//INICIALIZACION
    $(document).ready(function() {
        //CARGA DE DATOS FORMULARIO
        regionesFn();
        candidatosFn();
        fuentesFn();
        //EVENTOS
        $("#form_votacion").submit(function(e) {
            e.preventDefault();
        });
        $('#region').on('change', function() {
            comunasFn(this.value);
        });
    });