const chatLog = document.getElementById('chat-log');
const chatInput = document.getElementById('chat-input');
const sendBtn = document.getElementById('send-btn');
const imageInput = document.getElementById('image-input');
const uploadBtn = document.getElementById('upload-btn');
const imagePreview = document.getElementById('image-preview');

// Live Chat functionality
sendBtn.addEventListener('click', () => {
    const message = chatInput.value.trim();
    if (message !== '') {
        // Send the message to the server using AJAX
        fetch('/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            chatLog.innerHTML += `<p>${data.message}</p>`;
            chatInput.value = '';
        })
        .catch(error => console.error(error));
    }
});

// Image Upload functionality
uploadBtn.addEventListener('click', () => {
    const file = imageInput.files[0];
    if (file) {
        // Upload the image to the server using AJAX
        const formData = new FormData();
        formData.append('image', file);
        fetch('/upload-image', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            imagePreview.innerHTML = `<img src="${data.url}" alt="Uploaded Image">`;
        })
        .catch(error => console.error(error));
    }
});
