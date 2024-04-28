document.addEventListener('DOMContentLoaded', onload);

function onload() {
    const nodesProduct = document.querySelectorAll("td.product a");
console.log(nodesProduct);
    nodesProduct.forEach(nodeProduct => {
        nodeProduct.addEventListener('click', clickProduct);
    });
}

function clickProduct(event) {
    event.preventDefault();

    const dataIdProduct = this.getAttribute("data-idproduct");
    const container = document.getElementById("container");

    if (container.dataset.shown === dataIdProduct) {
        container.innerHTML = ''; 
        container.dataset.shown = ''; 
        return;
    }

    const dataRequest = {
        action: "getDetailProduct",
        idProduct: dataIdProduct,
        nomproducto: "nombre_del_producto",
        nameImg: "nombre_imagen",
        description: "descripcion"
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
                return response.text();
            } else {
                throw Error(response.status);
            }
        })
        .then((body) => {
            try {
                return JSON.parse(body);
            } catch {
                throw Error(body);
            }
        })
        .then((dataReturn) => {
            if (dataReturn["error"]) {
                console.log("Error en la solicitud:", dataReturn["error"]);
            } else {
                if (container) {
                    container.innerHTML = dataReturn;
                    container.dataset.shown = dataIdProduct; 
                }
            }
        })
        .catch((error) => {
            console.error("Error al realizar la solicitud:", error);
        });
}

