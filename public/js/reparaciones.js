const modeloSelect = document.getElementById('by-modelo');
const piezasDiv = document.getElementById('piezas');

modeloSelect.addEventListener('change', function() {
    const modeloId = modeloSelect.value;
    const dataRoute = modeloSelect.dataset.route;

    if (modeloId) {
        fetch(dataRoute.replace(/__id__/, modeloId))
            .then(response => response.json())
            .then(piezas => {
                const checkboxes = piezas.map(pieza => `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="piezas_${pieza.id}" name="reparaciones[pieza_id][]" value="${pieza.id}">
                        <label class="form-check-label" for="piezas_${pieza.id}">
                            ${pieza.nombre} - $${pieza.precio}
                        </label>
                    </div>
                `);

                piezasDiv.innerHTML = checkboxes.join('');
            })
            .catch(error => console.error(error));
    } else {
        piezasDiv.innerHTML = '';
    }
});
