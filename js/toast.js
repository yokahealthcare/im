const urlParams = new URLSearchParams(window.location.search);

const notifications = document.querySelector(".notifications"),
    buttons = document.querySelectorAll(".buttons .btn");

const toastDetails = {
    timer: 5000,
    success: {
        icon: 'fa-circle-check'
    },
    error: {
        icon: 'fa-circle-xmark'
    },
    warning: {
        icon: 'fa-triangle-exclamation'
    },
    info: {
        icon: 'fa-circle-info'
    }
}

const removeToast = (toast) => {
    toast.classList.add("hide");
    if(toast.timeoutId) clearTimeout(toast.timeoutId); // Clearing the timeout for the toast
    setTimeout(() => toast.remove(), 500); // Removing the toast after 500ms
}

const createToast = (id, text) => {
    // Getting the icon and text for the toast based on the id passed
    const { icon } = toastDetails[id];
    const toast = document.createElement("li"); // Creating a new 'li' element for the toast
    toast.className = `toast ${id}`; // Setting the classes for the toast
    // Setting the inner HTML for the toast
    toast.innerHTML = `<div class="column">
                         <i class="fa-solid ${icon}"></i>
                         <span>${text}</span>
                      </div>
                      <i class="fa-solid fa-xmark" onclick="removeToast(this.parentElement)"></i>`;
    notifications.appendChild(toast); // Append the toast to the notification ul
    // Setting a timeout to remove the toast after the specified duration
    toast.timeoutId = setTimeout(() => removeToast(toast), toastDetails.timer);
}

// Check if a specific key exists
if (urlParams.has('code') && urlParams.has('message')) {
    // Get the value of the key
    const code = urlParams.get('code');
    const message = urlParams.get('message').replace(/_/g, " ");

    if(code === "200") {
        createToast("success", message)
    } else if(code === "400") {
        createToast("error", message)
    } else if(code === "500") {
        createToast("error", message)
    }
}
