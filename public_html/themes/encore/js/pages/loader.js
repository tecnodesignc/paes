class Loader {
    hidden() {
        console.log('login hidden')
        $("#loader").addClass("hidden-loader");
    }

    show() {
        console.log('login show')
        $("#loader").removeClass("hidden-loader");
    }
}