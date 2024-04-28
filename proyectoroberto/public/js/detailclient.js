document.addEventListener('DOMContentLoaded', function () {
    const nodesClientes = document.querySelectorAll('nav ul li a')[0];
    nodesClientes.addEventListener('click', toggleClientesDropdown);
    const clientDetailsOverlay = document.getElementById('clientDetailsOverlay');

    if (clientDetailsOverlay) {
        clientDetailsOverlay.addEventListener('click', clickOverlayClient);
    }

    function toggleClientesDropdown(event) {
        event.preventDefault();
        const dropdownContent = document.getElementById('clientesDropdownContent');
        const isDropdownVisible = dropdownContent.classList.contains('show');
        const dataRequest = {
            action: 'getAllClient',
        };

        if (isDropdownVisible) {
            dropdownContent.classList.remove('show');
            return;
        }

        fetch('app/ajax/request_Fetch.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataRequest)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener los clientes: El servidor respondió con un estado no válido');
                }
                return response.json(); 
            })
            .then(dataReturn => {
                console.log(dataReturn); 
                dropdownContent.innerHTML = '';
                let listSearch = '';

                if (dataReturn.hasOwnProperty("status")) {
                    if (dataReturn.status.codError === "000") {
                        dataReturn.data.forEach(element => {
                            listSearch += `<tr data-client-id="${element.idClient}">`;
                            listSearch += `<td class="client-name">${element.nameClient}</td>`;
                            listSearch += `<td>${element.surnameClient}</td>`;
                            listSearch += '</tr>';
                        });

                        let tableHTML = '<table>';
                        tableHTML += '<tr><th>Nombre</th><th>Apellido</th></tr>';
                        tableHTML += listSearch;
                        tableHTML += '</table>';
                        dropdownContent.innerHTML = tableHTML;
                        dropdownContent.classList.toggle('show');

                        dropdownContent.querySelector('table').addEventListener('click', function (event) {
                            const target = event.target;
                            if (target.classList.contains('client-name')) {
                                const clientId = target.closest('tr').getAttribute('data-client-id');
                                console.log('clientId:', clientId); // Verificar el valor de clientId
                                showClientDetailsOverlay(clientId);
                            }
                        });
                    } else {
                        console.error("Error al obtener los clientes:", dataReturn.status.mensaje);
                    }
                } else {
                    console.error("La respuesta del servidor no contiene la clave 'status'.");
                }
            })
            .catch(error => {
                console.error('Error al obtener los clientes:', error);
            });
    }

    document.addEventListener('click', function (event) {
        const dropdownContent = document.getElementById('clientesDropdownContent');
        const nodesClientes = document.querySelectorAll('nav ul li a')[0];
        if (!dropdownContent.contains(event.target) && event.target !== nodesClientes) {
            dropdownContent.classList.remove('show');
        }
    });
});

function showClientDetailsOverlay(clientId) {
    console.log("Mostrando overlay de detalles para el cliente con ID:", clientId);
    const clientDetailsOverlay = document.getElementById('clientDetailsOverlay');
    if (clientDetailsOverlay) {
        clientDetailsOverlay.classList.remove('hiddenD'); 
    }

    console.log("ID del cliente enviado al servidor:", clientId);

    const dataRequest = {
        action: "getDetailClient",
        idClient: clientId
    };

    fetch("app/ajax/request_Fetch.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataRequest)
    })
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                throw Error(response.status);
            }
        })
        .then((dataReturn) => {
            console.log(dataReturn);
            if (dataReturn["error"]) {
                console.error("Error en la solicitud:", dataReturn["error"]);
                alert("Error: " + dataReturn["error"]);
            } else {
                const container = document.getElementById("clientDetailsOverlay");
                if (container) {
                    let html = "<div class='clientdetailoverlay__board'>";
                    html += `<button class="close-button" onclick="hideClientDetailsOverlay()">×</button>`;
                    html += `<p>Nombre: ${dataReturn.nameClient}</p>`;
                    html += `<p>Apellido: ${dataReturn.surnameClient}</p>`;
                    html += `<p>Dirección: ${dataReturn.address}</p>`;
                    html += `<p>email: ${dataReturn.email}</p>`;
                    html += "</div>";
                    container.innerHTML = html;
                    container.dataset.shown = clientId;
                }
            }
        })
        .catch((error) => {
            console.error("Error al realizar la solicitud:", error);
            alert("Error al realizar la solicitud: " + error.message);
        });
}

function clickOverlayClient(event) {
 
    console.log(event);
    console.log(this);
    if (this === event.target) {
        
        this.classList.add("hiddenD");
    }
    event.stopPropagation(); 
}


