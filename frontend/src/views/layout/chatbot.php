<div id="chatbot-container" class="fixed bottom-6 right-6 z-50">
    
    <button id="chatbot-toggle" onclick="toggleChat()" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-2xl transition-transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-blue-300">
        <svg id="chatbot-icon-closed" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <svg id="chatbot-icon-open" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <div id="chatbot-window" class="hidden absolute bottom-20 right-0 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden flex-col transition-all duration-300 transform scale-95 opacity-0 origin-bottom-right" style="height: 500px; max-height: 80vh;">
        
        <div class="bg-gradient-to-r from-blue-600 to-teal-500 p-4 text-white flex justify-between items-center shadow-md z-10">
            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                </svg>
                <h3 class="font-bold text-lg">Asistente Virtual</h3>
            </div>
            <select id="chatbot-lang" onchange="cambiarIdioma()" class="bg-white/20 text-white border-none rounded-lg text-sm px-2 py-1 focus:ring-0 outline-none cursor-pointer">
                <option value="es" class="text-black">Español</option>
                <option value="en" class="text-black">English</option>
                <option value="fr" class="text-black">Français</option>
                <option value="ar" class="text-black">العربية</option>
            </select>
        </div>

        <div id="chatbot-messages" class="flex-1 p-4 overflow-y-auto bg-gray-50 flex flex-col gap-3">
        </div>

        <div class="p-3 border-t border-gray-200 bg-white">
            <form id="chatbot-form" onsubmit="enviarMensajeUsuario(event)" class="flex gap-2 relative">
                <input type="text" id="chatbot-input" autocomplete="off" placeholder="Escribe tu mensaje..." class="flex-1 border-gray-300 rounded-full pl-4 pr-10 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 outline-none border shadow-inner">
                <button type="submit" class="absolute right-2 top-1.5 bottom-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-full w-8 h-8 flex items-center justify-center transition disabled:opacity-50" id="chatbot-submit" disabled>
                    <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const chatWindow = document.getElementById('chatbot-window');
    const chatToggle = document.getElementById('chatbot-toggle');
    const iconClosed = document.getElementById('chatbot-icon-closed');
    const iconOpen = document.getElementById('chatbot-icon-open');
    const msgContainer = document.getElementById('chatbot-messages');
    const inputField = document.getElementById('chatbot-input');
    const submitBtn = document.getElementById('chatbot-submit');
    const langSelect = document.getElementById('chatbot-lang');
    
    let chatAbierto = false;
    let saludoCargado = false;

    // Validar input para habilitar el boton de enviar
    inputField.addEventListener('input', () => {
        submitBtn.disabled = inputField.value.trim().length === 0;
    });

    function toggleChat() {
        chatAbierto = !chatAbierto;
        
        if (chatAbierto) {
            chatWindow.classList.remove('hidden');
            setTimeout(() => {
                chatWindow.classList.remove('scale-95', 'opacity-0');
                chatWindow.classList.add('flex');
            }, 10);
            
            iconClosed.classList.add('hidden');
            iconOpen.classList.remove('hidden');
            
            if (!saludoCargado) {
                solicitarRespuestaAPI("");
                saludoCargado = true;
            } else {
                hacerScroll();
            }
            
            setTimeout(() => inputField.focus(), 300);
        } else {
            chatWindow.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                chatWindow.classList.add('hidden');
                chatWindow.classList.remove('flex');
            }, 300);
            
            iconClosed.classList.remove('hidden');
            iconOpen.classList.add('hidden');
        }
    }

    function cambiarIdioma() {
        msgContainer.innerHTML = '';
        solicitarRespuestaAPI("");
        
        // Cambiar placeholder según idioma (Detalle para la memoria)
        const placeholders = {
            'es': 'Escribe tu mensaje...',
            'en': 'Type your message...',
            'fr': 'Écrivez votre message...',
            'ar': 'اكتب رسالتك...'
        };
        inputField.placeholder = placeholders[langSelect.value] || placeholders['es'];
        inputField.dir = langSelect.value === 'ar' ? 'rtl' : 'ltr';
    }

    function añadirMensajeUI(texto, emisor) {
        const div = document.createElement('div');
        const isBot = emisor === 'bot';
        
        div.className = `max-w-[85%] rounded-2xl px-4 py-2 text-sm shadow-sm ${isBot ? 'bg-white border border-gray-100 text-gray-800 self-start rounded-tl-none' : 'bg-blue-600 text-white self-end rounded-tr-none'}`;
        div.setAttribute('dir', 'auto');
        div.textContent = texto;
        
        msgContainer.appendChild(div);
        hacerScroll();
    }

    function añadirIndicadorEscribiendo() {
        const div = document.createElement('div');
        div.id = 'bot-typing';
        div.className = 'bg-white border border-gray-100 text-gray-500 max-w-[85%] self-start rounded-2xl rounded-tl-none px-4 py-3 shadow-sm flex items-center gap-1';
        div.innerHTML = `
            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></div>
            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
        `;
        msgContainer.appendChild(div);
        hacerScroll();
    }

    function eliminarIndicadorEscribiendo() {
        const typing = document.getElementById('bot-typing');
        if (typing) typing.remove();
    }

    function hacerScroll() {
        msgContainer.scrollTop = msgContainer.scrollHeight;
    }

    function enviarMensajeUsuario(e) {
        e.preventDefault();
        const texto = inputField.value.trim();
        if (!texto) return;

        inputField.value = '';
        submitBtn.disabled = true;

        añadirMensajeUI(texto, 'user');
        solicitarRespuestaAPI(texto);
    }

    async function solicitarRespuestaAPI(mensaje) {
        const lang = langSelect.value;
        const apiPath = 'http://localhost:5000/api/chatbot';
        
        if (mensaje !== "") añadirIndicadorEscribiendo();

        try {
            const res = await fetch(apiPath, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: mensaje, language: lang })
            });
            
            const data = await res.json();
            
            if (mensaje !== "") eliminarIndicadorEscribiendo();
            
            setTimeout(() => {
                añadirMensajeUI(data.response || "Error", 'bot');
            }, 300);

        } catch (e) {
            console.error("Error chatbot:", e);
            eliminarIndicadorEscribiendo();
            añadirMensajeUI("Error de conexión con el servidor. Inténtalo más tarde.", 'bot');
        }
    }
</script>
