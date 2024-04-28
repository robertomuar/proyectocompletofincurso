let nodesMarcas; // Declara nodesMarcas aquí para que tenga un alcance más amplio
document.addEventListener('DOMContentLoaded', onload);
function onload() {
    nodesMarcas = document.querySelectorAll('nav ul li a')[1]; // Asigna el valor aquí
    nodesMarcas.addEventListener('click', toggleDropdown); // Agrega el evento al enlace de marcas
}


function toggleDropdown(event) {
    console.log('INICIO toggleDropdown');
    event.preventDefault();
    const dropdownContent = document.getElementById('marcasDropdownContent');
    const isDropdownVisible = dropdownContent.classList.contains('show');

    if (isDropdownVisible) {
        console.log('Dropdown ya visible, ocultándolo');
        dropdownContent.classList.remove('show');
        return;
    }

    const dataRequest = {
        action: 'getAllBrands',
    };

    fetch('app/ajax/request_Fetch.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataRequest)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al obtener las marcas');
        }
        return response.json();
    })
    .then(dataReturn => {
        console.log('Datos recibidos:', dataReturn);
        let listSearch = '';
        if (dataReturn["status"]["codError"] === "000") {
            dataReturn["data"].forEach(element => {
                listSearch += `<div>`;
                listSearch += `<a href='detailBrand.php?idbrand=${element.idBrand}'><img src="${element.nameLogo}" alt="${element.nameBrand}" title="${element.nameBrand}" width="100%"></a>`;
                listSearch += `</div>`;
            });
           
            dropdownContent.innerHTML = listSearch;

            dropdownContent.classList.add('show');
            console.log('Dropdown mostrado');

        } else {
            console.error('Error al obtener las marcas: Data no es un array.');
        }
    })
    .catch(error => {
        console.error('Error al obtener las marcas:', error);
    });

    document.addEventListener('click', function(event) {
        console.log('Clic en documento');
        if (!dropdownContent.contains(event.target) && event.target !== nodesMarcas) {
            console.log('Cerrando menú desde documento');
            dropdownContent.classList.remove('show');
        }
    });
}
