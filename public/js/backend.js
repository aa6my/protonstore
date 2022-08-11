window.addEventListener('DOMContentLoaded', () => {

    // side bar active state switching.
    switch (document.querySelector("body").id) 
    {
        case ("dashboard"):
            document.querySelector("#sidebar-dashboard").classList.add("sidebar-active");
            break;
        case ("orders"):
            document.querySelector("#sidebar-orders").classList.add("sidebar-active");
            break;
        case ("car"):
            document.querySelector("#sidebar-car").classList.add("sidebar-active");
            break;
        case ("accountCreation"):
            document.querySelector("#sidebar-account").classList.add("sidebar-active");
            break;
    }

})
