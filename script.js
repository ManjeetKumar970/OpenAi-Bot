document.getElementById("chat-form").addEventListener("submit", async function (e) {
    e.preventDefault();

    const input = document.getElementById("user-message");
    const message = input.value.trim();
    if (!message) return;

    appendMessage("user", message);
    input.value = "";

    const res = await sendToChatbot(message);
    appendMessage(res.role, res.content);
});

async function sendToChatbot(message) {
    console.log(message);
    try {
        const res = await fetch("process.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `user-message=${encodeURIComponent(message)}`
        });

        const data = await res.json();
        if (data.error) throw new Error(data.error);
        return data;

    } catch (err) {
        console.error("Chatbot error:", err);
        return {
            role: "assistant",
            content: "Sorry, something went wrong."
        };
    }
}

function appendMessage(role, text) {
    const chatBox = document.getElementById("chat-box");
    const div = document.createElement("div");
    div.className = role;

    // Create logo for bot
    if (role === 'assistant') {
        const logo = document.createElement("img");
        logo.src = "boot.png"; 
        logo.alt = "Bot Logo";
        logo.style.width = "24px";
        logo.style.height = "24px";
        logo.style.verticalAlign = "middle";
        logo.style.marginRight = "8px";
        div.appendChild(logo);
        div.style.backgroundColor = "#27ae60"; 
        div.style.color = "#fff";
    }

    const span = document.createElement("span");
    span.textContent = `${role === 'user' ? 'You' : 'Bot'}: ${text}`;
    div.appendChild(span);

    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}
