function showClientDetailsOverlay(clientId) {
    fetch('app/ajax/request_Fetch.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ clientId: clientId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al obtener los clientes: El servidor respondió con un estado no válido');
        }
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json(); 
        } else {
            throw new Error('La respuesta del servidor no es JSON');
        }
    })
    .then(data => {
        console.log("Datos recibidos:", data);
    })
    .catch(error => {
        console.error('Error al obtener los detalles del cliente:', error);
    });
}
