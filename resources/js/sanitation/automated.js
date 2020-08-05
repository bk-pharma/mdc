new Vue({
    el: '#automatedPhases-container',
    data() {
        return {
           automatedLabel : '',

        }
    },

methods : {
    startConsole : function(){
        this.automatedLabel = 'Starting to Sanitize all the data . . . .';
        /* setInterval(function(){ alert("Hello"); }, 60 * 1000); */
        window.location.href = `automated/start-sanitize`;
    },
    
}

});