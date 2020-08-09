new Vue({
    el: '#automatedPhases-container',
    data() {
        return {
           automatedLabel : '',
           sanitationBtn: false,
           rowCount: 1000,
           processRowStartArr: [],
           totalSanitizedRow: 0,
           totalSanitizedAmount: 0
        }
    },

methods : {
    startConsole: function()
    {
        this.automatedLabel = 'Starting to Sanitize all the data . . . .';

        let rowsPerSanitationProcess = 50;
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

            this.processRowStartArr.push(processRowStart);
        }

        this.sanitationProcess(0, this.processRowStartArr[0], rowsPerSanitationProcess);
    },
    sanitationProcess: function(index, rowStart, rowCount)
    {
        let totalProcess = this.processRowStartArr.length;

        axios.get(`automated/start-process/${rowStart}/${rowCount}`)
        .then((response) =>
        {
            let nextRowStart = this.processRowStartArr[index + 1];
            let nextIndex = index + 1;

            if(typeof nextRowStart !== 'undefined')
            {
                this.sanitationProcess(nextIndex, nextRowStart, rowCount);
            }
        })
        .catch((error) =>
        {
            console.log(error);
        })
    },
    sanitizedCount: function()
    {
        axios.get(`automated/sanitized-total`)
        .then((response) => {

            let resp = response.data;
            console.log(resp);

        })
        .catch((error) => {

        })
    }
}

});