document.addEventListener('DOMContentLoaded', onload);

function onload() {
    document.addEventListener('click', function(event) {
        const dropdownPedidos = document.getElementById('orderDropdownContent');
        if (!dropdownPedidos.contains(event.target)) {
            dropdownPedidos.classList.remove('show');
        }
    });

    const nodesPedidos = document.querySelectorAll('nav ul li a')[2]; 

    nodesPedidos.addEventListener('click', toggleDropdown.bind(null, 'orderDropdownContent'));

    function toggleDropdown(dropdownId, event) {
        event.preventDefault();
        const dropdownContent = document.getElementById(dropdownId);
        const isDropdownVisible = dropdownContent.classList.contains('show');
        const dataRequest = {
            action: 'getAllOrder',
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
                throw new Error('Error al obtener los datos');
            }
            return response.json();
        })
        .then(dataReturn => {
         
            dropdownContent.innerHTML = '';

            if (dataReturn.status.codError === "000") {
                let tableHTML = '<table>';
                tableHTML += '<tr><th>Nº Pedido</th><th>Cliente</th></tr>';
                dataReturn.data.forEach(element => {
                    let fullName = element.nameClient + ' ' + element.surnameClient;
                    tableHTML += '<tr>';
                    tableHTML += `<td>${element.idOrder}</td>`;
                    tableHTML += `<td>${fullName}</td>`;
                    tableHTML += '</tr>';
                });
        
                tableHTML += '</table>';
                dropdownContent.innerHTML = tableHTML;
            } else {
                console.error('Error al obtener los datos: Data no es un array.');
            }
            dropdownContent.classList.toggle('show');
        })
        .catch(error => {
            console.error('Error al obtener los datos:', error);
        });
    }
}
