(function () {

    obtenerTareas();
    // Boton para mostrar el Modal de Agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFromulario);

    async function obtenerTareas() {
        try {
            const id = obtenerProyecto();
            const url = `/api/tareas?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            const { tareas } = resultado;
            mostrarTareas(tareas);
            //console.log(tareas);
        } catch (error) {
            console(error);
        }
    }

    function mostrarTareas(tareas) {
        if (tareas.length === 0) {
            const contenedorTareas = document.querySelector('#listado-tareas');

            const textoNoTareas = document.createElement('LI');
            textoNoTareas.textContent = 'No hay Tareas';
            textoNoTareas.classList.add('no-tareas');

            contenedorTareas.appendChild(textoNoTareas);
            return;
        }
        const estados = {
            0: 'Pendiente',
            1: 'Completa'
        }

        tareas.forEach(tarea => {
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;

            console.log(btnEstadoTarea);
        });
    }

    function mostrarFromulario() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML =`
        <form class = "formulario nueva-tarea">
        <legend>Añade una Nueva Tarea</legend>
        <div class = "campo">
            <label>Tarea: </label>
            <input type="text" name="tarea" id="tarea" placeholder="Añadir Tarea al Proyecto Actual" />
        </div>
        <div class="opciones">
            <input type="submit" id= "crear-tarea" class="submit-nueva-tarea" value="Añadir Tarea">
            <button type="button" id= "cancelar" class="cerrar-modal">Cancelar</button>
        </div>
        </form>
        `;
        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);

        modal.addEventListener('click', function (e) {
            e.preventDefault();
            if (e.target.classList.contains('cerrar-modal')) {
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
                
            }
            if (e.target.classList.contains('submit-nueva-tarea')) {
                submitFormularioNuevaTarea();
            }
            //console.log(e.target);
        });

        document.querySelector('.dashboard').appendChild(modal);
    }
    
    function submitFormularioNuevaTarea() {
        const tarea = document.querySelector('#tarea').value.trim();

        if (tarea === '') {
            //Mostrar alerta de error
            mostrarAlerta('El Nombre de la Tarea es Obligatorio', 'error',
                document.querySelector('.formulario legend'));
            return;
        }
        agregarTarea(tarea);
    }
    //Muestra un mensaje en la interfaz
    function mostrarAlerta(mensaje, tipo, referencia) {
        // Previene la creacion de multiples alertas
        const alertaprevia = document.querySelector('.alerta');
        if (alertaprevia) {
            alertaprevia.remove();
        }
        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

        // console.log(referencia);
        // console.log(referencia.parentElement);
        // console.log(referencia.nextElementSibling);
        //referencia.appendChild(alerta);

        //Eliminar la alerta despues de 5 segundos
        setTimeout(() => {
            alerta.remove();
        }, 5000);
    }
    //Consultar el servidor para añadir una nueva tarea al proyecto actual 
    async function agregarTarea(tarea) {
        // Construir la peticion
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyecto_id', obtenerProyecto());

        // const url = new URL(window.location);
        // const id = url.searchParams.get('id');
        // console.log(id);

        try {
            // Deshablilitar botones 
            const crearTarea = document.querySelector('#crear-tarea');
            const cancelar = document.querySelector('#cancelar');
            crearTarea.disabled = true;
            cancelar.disabled = true;
                
            const url = 'http://localhost:3000/api/tarea';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            mostrarAlerta(resultado.mensaje, resultado.tipo, document.
            querySelector('.formulario legend'));
            console.log(resultado);
            if (resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');

                setTimeout(() => {
                    modal.remove();
                }, 3000);
            }
            
        } catch (error) {
            console.log(error);
        }
    }

    function obtenerProyecto() {
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }
})();
