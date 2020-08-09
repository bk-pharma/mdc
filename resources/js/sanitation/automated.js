new Vue({
    el: '#automatedPhases-container',
    data() {
        return {
           automatedLabel : '',
           sanitationBtn: false,
           rowCount: 1000
        }
    },

methods : {
    startConsole: function()
    {
        this.automatedLabel = 'Starting to Sanitize all the data . . . .';

        let rowsPerSanitationProcess = 100;
        let sanitationProcessNeeded = (this.rowCount / rowsPerSanitationProcess);
        let processRowStart = 0;

        for(let i = 0; i < sanitationProcessNeeded; i++)
        {
            if(i === 0)
            {
                processRowStart = 0;
            }else
            {
                processRowStart = (i * rowsPerSanitationProcess) + 1;
            }

            this.sanitationProcess(processRowStart, rowsPerSanitationProcess);
        }
    },
    sanitationProcess: function(rowStart, rowCount)
    {
        axios.get(`automated/start-process/${rowStart}/${rowCount}`)
        .then((response) =>
        {
            console.log(response.data);
        })
        .catch((error) =>
        {

        })
    }
}

});