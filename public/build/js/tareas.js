!function(){!async function(){try{const a="/api/tareas?id="+r(),o=await fetch(a),n=await o.json();e=n.tareas,t()}catch(e){console(e)}}();let e=[];function t(){if(function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),0===e.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("LI");return t.textContent="No hay Tareas",t.classList.add("no-tareas"),void e.appendChild(t)}const o={0:"Pendiente",1:"Completa"};e.forEach(c=>{const i=document.createElement("LI");i.dataset.tareaId=c.id,i.classList.add("tarea");const d=document.createElement("P");d.textContent=c.nombre,d.ondblclick=function(){a(!0,{...c})};const s=document.createElement("DIV");s.classList.add("opciones");const l=document.createElement("BUTTON");l.classList.add("estado-tarea"),l.classList.add(""+o[c.estado].toLowerCase()),l.textContent=o[c.estado],l.dataset.estadoTarea=c.estado,l.ondblclick=function(){!function(e){const t="1"===e.estado?"0":"1";e.estado=t,n(e)}({...c})};const m=document.createElement("BUTTON");m.classList.add("eliminar-tarea"),m.dataset.idTarea=c.id,m.textContent="Eliminar",m.ondblclick=function(){!function(a){Swal.fire({title:"¿Eliminar Tarea?",showCancelButton:!0,confirmButtonText:"Si",cancelButtonText:"No"}).then(o=>{o.isConfirmed&&async function(a){const{estado:o,id:n,nombre:c}=a,i=new FormData;i.append("id",n),i.append("nombre",c),i.append("estado",o),i.append("proyecto_id",r());try{const o="http://localhost:3000/api/tarea/eliminar",n=await fetch(o,{method:"POST",body:i}),r=await n.json();r.resultado&&(Swal.fire("Eliminado!",r.mensaje,"success"),e=e.filter(e=>e.id!==a.id),t())}catch(e){console.log(e)}}(a)})}({...c})},s.appendChild(l),s.appendChild(m),i.appendChild(d),i.appendChild(s);document.querySelector("#listado-tareas").appendChild(i)})}function a(a=!1,c={}){const i=document.createElement("DIV");i.classList.add("modal"),i.innerHTML=`\n        <form class = "formulario nueva-tarea">\n        <legend> ${a?"Editar Tarea":"Añade una Nueva Tarea"}</legend>\n        <div class = "campo">\n            <label>Tarea: </label>\n            <input\n                type="text"\n                name="tarea"\n                id="tarea"\n                value="${c.nombre?c.nombre:""}"\n                placeholder="${c.nombre?"Edita la tarea":"Añadir Tarea al Proyecto Actual"}" \n            />\n        </div>\n        <div class="opciones">\n            <input type="submit" id= "crear-tarea" class="submit-nueva-tarea" value="${a?"Guardar Cambios":"Añadir Tarea"}">\n            <button type="button" id= "cancelar" class="cerrar-modal">Cancelar</button>\n        </div>\n        </form>\n        `,setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),i.addEventListener("click",(function(d){if(d.preventDefault(),d.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{i.remove()},500)}if(d.target.classList.contains("submit-nueva-tarea")){const i=document.querySelector("#tarea").value.trim();if(""===i)return void o("El Nombre de la Tarea es Obligatorio","error",document.querySelector(".formulario legend"));a?(c.nombre=i,n(c)):async function(a){const n=new FormData;n.append("nombre",a),n.append("proyecto_id",r());try{const r=document.querySelector("#crear-tarea"),c=document.querySelector("#cancelar");r.disabled=!0,c.disabled=!0;const i="http://localhost:3000/api/tarea",d=await fetch(i,{method:"POST",body:n}),s=await d.json();if(o(s.mensaje,s.tipo,document.querySelector(".formulario legend")),console.log(s),"exito"===s.tipo){const o=document.querySelector(".modal");setTimeout(()=>{o.remove()},2200);const n={id:String(s.id),nombre:a,estado:"0",proyecto_id:s.proyecto_id};e=[...e,n],t()}}catch(e){console.log(e)}}(i)}})),document.querySelector(".dashboard").appendChild(i)}function o(e,t,a){const o=document.querySelector(".alerta");o&&o.remove();const n=document.createElement("DIV");n.classList.add("alerta",t),n.textContent=e,a.parentElement.insertBefore(n,a.nextElementSibling),setTimeout(()=>{n.remove()},5e3)}async function n(a){const{estado:o,id:n,nombre:c}=a,i=new FormData;i.append("id",n),i.append("nombre",c),i.append("estado",o),i.append("proyecto_id",r());try{const a="http://localhost:3000/api/tarea/actualizar",r=await fetch(a,{method:"POST",body:i}),d=await r.json();if("exito"===d.respuesta.tipo){Swal.fire(d.respuesta.mensaje,"","success");const a=document.querySelector(".modal");a&&a.remove(),e=e.map(e=>(e.id===n&&(e.estado=o,e.nombre=c),e)),t()}}catch(e){console.log(e)}}function r(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}document.querySelector("#agregar-tarea").addEventListener("click",(function(){a()}))}();