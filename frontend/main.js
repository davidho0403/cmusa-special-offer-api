const getLocation = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(sendPosition, showError);
    } else {
        window.alert("The Browser Does not Support Geolocation");
    }
};

const showError = (error) => {
    if (error.PERMISSION_DENIED) {
        window.alert("The User have denied the request for Geolocation.");
    }
};

