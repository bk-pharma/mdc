new Vue({
    el: '#automatedPhases-container',
    data() {
        return {
           automatedLabel : '',
           sanitationBtn: false,
           processRowStartArr: [],
           rowCount: 0,
           rowCountField: false,
           totalSanitizedRow: 0,
           totalUnsanitizedRow: 0,
           totalSanitizedAmount: 0,
           totalRaw: 0,
           currentSanitationProcess: 0,
           totalSanitationProcess:  0
        }
    },
    created() {
        this.sanitizedCount('start');
    },
    methods : {
        startConsole: function()
        {
            this.automatedLabel = 'Sanitation in process...';

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

            this.totalSanitationProcess = (this.processRowStartArr.length - 1);

            this.sanitationProcess(0, this.processRowStartArr[0], rowsPerSanitationProcess);
        },
        sanitationProcess: function(index, rowStart, rowCount)
        {
           this.currentSanitationProcess = index;
           this.rowCountField = true;
           this.sanitationBtn = true;

            axios.get(`automated/start-process/${rowStart}/${rowCount}`)
            .then((response) =>
            {
                this.sanitizedCount(null);

                let nextRowStart = this.processRowStartArr[index + 1];
                let nextIndex = index + 1;

                if(typeof nextRowStart !== 'undefined')
                {
                    this.sanitationProcess(nextIndex, nextRowStart, rowCount);
                }else
                {
                    this.automatedLabel = '';
                    this.rowCountField = false;
                    this.sanitationBtn = false;
                }
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitizedCount: function(callFrom)
        {
            axios.get(`automated/sanitized-total`)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                if(callFrom === 'start')
                {
                    this.rowCount = this.totalUnsanitizedRow;
                }
            })
            .catch((error) => {

            })
        }
    }

});