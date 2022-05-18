const getLocation = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(sendPosition, showError);
    } else {
        window.alert("The Browser Does not Support Geolocation");
    }
};

