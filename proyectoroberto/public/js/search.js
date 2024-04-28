document.addEventListener('DOMContentLoaded', onload);

function onload() {
    const nodeSearch = document.querySelector("#search");

    window.addEventListener("resize", onResizeWindow);

    nodeSearch.addEventListener('input', inputSearch);
    nodeSearch.addEventListener('keydown', keydownSearch);
    nodeSearch.addEventListener('focus', focusSearch);

    document.body.addEventListener("click", exitSearch);
}

function keydownSearch(event) {

    if (event.keyCode === 13) {
        const q = this.value;
        window.location.href = `main1.php?q=${q}`;
    }
}

function onResizeWindow() {
    moveWrapperSearch();
}

function focusSearch(event) {
    const nodeWrapperSearch = document.querySelector(".wrappersearch");
    if (nodeWrapperSearch.innerHTML !== "") {
        nodeWrapperSearch.classList.remove("hiddend");
    }
}

function exitSearch(event) {

    const nodeSearch = document.querySelector("#search");
    if (event.target !== nodeSearch) {
        const nodeWrapperSearch = document.querySelector(".wrappersearch");
        nodeWrapperSearch.classList.add("hiddend");
    }
}

function inputSearch(event) {


    if (event.target.value.trim() !== "") {
        const dataRequest = {
            action: "setSearch",
            search: event.target.value
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

                const nodeWrapperSearch = document.querySelector(".wrappersearch");
                let listSearch = "";
                if (dataReturn["status"]["codError"] === "000") {
                    const uniqueClients = {}; 
                    dataReturn["data"].forEach(client => {
                        if (!uniqueClients.hasOwnProperty(client.idClient)) {
                            const clientInfo = `<div class='clientinfo'><div class='clientname'>Nombre: ${client.nameClient} ${client.surnameClient}</div>`;
                            listSearch += `<div class='clientcontainer'>${clientInfo}`;

                            if (client.hasOwnProperty('orders')) {
                                client.orders.forEach(idOrder => {
                                    listSearch += `<div class='order'>ID del Pedido: ${idOrder}</div>`;
                                });
                            }
                            listSearch += `</div>`;

                            uniqueClients[client.idClient] = true;
                        }
                    });
         
                    nodeWrapperSearch.innerHTML = listSearch;
                } else {
                    nodeWrapperSearch.innerHTML = "Busca otra cosa.";
                }
                nodeWrapperSearch.classList.remove("hiddend");
                moveWrapperSearch();
            })
            .catch((error) => {
      
              console.error(error);
            });
    } else {
        const nodeWrapperSearch = document.querySelector(".wrappersearch");
        nodeWrapperSearch.innerHTML = "";
        nodeWrapperSearch.classList.add("hiddend");
    }
}

function moveWrapperSearch() {
    const nodeInput = document.querySelector("#search");

    const dataInput = nodeInput.getBoundingClientRect();

    const nodeWrapperSearch = document.querySelector(".wrappersearch");
    nodeWrapperSearch.style.width = dataInput.width + "px";
    nodeWrapperSearch.style.top = dataInput.bottom + "px";
    nodeWrapperSearch.style.left = dataInput.left + "px";
}

function clickOverlay(event) {

    if (this === event.target) {
        this.classList.add("hiddenD");
    }
}
