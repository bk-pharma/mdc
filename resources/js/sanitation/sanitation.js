new Vue({
    el: '#sanitation-container',
    data() {
        return {
           automatedLabel : '',
           sanitationBtn: false,
           processRowStartArr: [],
           rowCount: 0,
           sanitationWorker1: 0,
           sanitationWorker2: 0,
           sanitationWorker3: 0,
           sanitationWorker4: 0,
           sanitationWorker5: 0,
           sanitationWorker6: 0,
           sanitationWorker7: 0,
           sanitationWorker8: 0,
           sanitationWorker9: 0,
           sanitationWorker10: 0,
           rowCountField: false,
           totalSanitizedRow: 0,
           percentageSanitizedRow: 0,
           totalUnsanitizedRow: 0,
           totalSanitizedAmount: 0,
           totalRaw: 0,
           rowsPerSanitationProcess: 500,
           currentSanitationProcess: 0,
           totalSanitationProcess:  0,
           percentageSanitationProcess: 0
        }
    },
    filters: {
        numberFormat: function(num)
        {
            if(num)
            {
                return num.toLocaleString();
            }else
            {
                return num;
            }
        },
        decimalFormat: function(num)
        {
            if(num || !isNaN(num))
            {
                return num.toFixed(2);
            }else
            {
                return num;
            }
        }
    },
    created()
    {
        this.initialData();
    },
    updated()
    {
        if(this.currentSanitationProcess === this.totalSanitationProcess)
        {
            this.automatedLabel = '';
            this.sanitationBtn = false;
            this.rowCountField = false;
        }

        this.currentSanitationProcess = (
                this.sanitationWorker1 +
                this.sanitationWorker2 +
                this.sanitationWorker3 +
                this.sanitationWorker4 +
                this.sanitationWorker5 +
                this.sanitationWorker6
            ) / 8;
    },
    methods : {
        startConsole: function()
        {
            this.automatedLabel = 'Sanitation in process...';

            let sanitationProcessNeeded = (this.rowCount / this.rowsPerSanitationProcess);
            let processRowStart = 0;

            for(let i = 0; i < sanitationProcessNeeded; i++)
            {
                if(i === 0)
                {
                    processRowStart = 0;
                }else
                {
                    processRowStart = (i * this.rowsPerSanitationProcess) + 1;
                }

                this.processRowStartArr.push(processRowStart);
            }

            Object.freeze(this.processRowStartArr);

            let firstSanitationIndexes = [0, 199]; // 0 - 100k;
            let secondSanitationIndexes = [200, 399]; // 101k - 200k
            let thirdSanitationIndexes = [400, 599]; // 201k - 300k
            let fourthSanitationIndexes = [600, 799]; // 301k - 400k
            let fifthSanitationIndexes = [800, 999]; // 401k - 500k
            let sixthSanitationIndexes = [1000, 1199]; // 501k - 600k
            let seventhSanitationIndexes = [1200, 1399]; // 601k - 700k
            let eightSanitationIndexes = [1400, 1599]; // 701k - 800k
            let nineSanitationIndexes = [1600, 1799]; // 801k - 900k
            let tenthSanitationIndexes = [1800, 1999]; // 901k - 1M


            if(typeof this.processRowStartArr[0] !== 'undefined')
            {
                this.sanitationProcessOneParent(firstSanitationIndexes[0], firstSanitationIndexes[1]);

                setTimeout(() => {
                    console.log('process one child started');
                    this.sanitationProcessOneChild(firstSanitationIndexes[0], firstSanitationIndexes[1]);
                 }, 300000);
            }

            // if(typeof this.processRowStartArr[200] !== 'undefined')
            // {
            //     this.sanitationProcess2(secondSanitationIndexes[0], secondSanitationIndexes[1]);

            //     setTimeout(() => {
            //         console.log('process 2 1st sub function started');
            //         this.sanitationProcess2(secondSanitationIndexes[0], secondSanitationIndexes[1]);
            //     },180000);

            //     setTimeout(() => {
            //         console.log('process 2 2nd sub function started');
            //         this.sanitationProcess2(secondSanitationIndexes[0], secondSanitationIndexes[1]);
            //     },360000);

            //     setTimeout(() => {
            //         console.log('process 2 3rd sub function started');
            //         this.sanitationProcess2(secondSanitationIndexes[0], secondSanitationIndexes[1]);
            //     },540000);

            //     setTimeout(() => {
            //         console.log('process 2 4th sub function started');
            //         this.sanitationProcess2(secondSanitationIndexes[0], secondSanitationIndexes[1]);
            //     },720000);

            //     setTimeout(() => {
            //         console.log('process 2 5th sub function started');
            //         this.sanitationProcess2(secondSanitationIndexes[0], secondSanitationIndexes[1]);
            //     },900000);

            //     setTimeout(() => {
            //         console.log('process 2 6th sub function started');
            //         this.sanitationProcess2(secondSanitationIndexes[0], secondSanitationIndexes[1]);
            //      }, 1080000);

            //     setTimeout(() => {
            //         console.log('process 2 7th sub function started');
            //         this.sanitationProcess2(secondSanitationIndexes[0], secondSanitationIndexes[1]);
            //      }, 1260000);
            // }

            // if(typeof this.processRowStartArr[400] !== 'undefined')
            // {
            //     this.sanitationProcess3(thirdSanitationIndexes[0], thirdSanitationIndexes[1]);

            //     setTimeout(() => {
            //         console.log('process 3 1st sub function started');
            //         this.sanitationProcess3(thirdSanitationIndexes[0], thirdSanitationIndexes[1]);
            //     },180000);

            //     setTimeout(() => {
            //         console.log('process 3 2nd sub function started');
            //         this.sanitationProcess3(thirdSanitationIndexes[0], thirdSanitationIndexes[1]);
            //     },360000);

            //     setTimeout(() => {
            //         console.log('process 3 3rd sub function started');
            //         this.sanitationProcess3(thirdSanitationIndexes[0], thirdSanitationIndexes[1]);
            //     },540000);

            //     setTimeout(() => {
            //         console.log('process 3 4th sub function started');
            //         this.sanitationProcess3(thirdSanitationIndexes[0], thirdSanitationIndexes[1]);
            //     },720000);

            //     setTimeout(() => {
            //         console.log('process 3 5th sub function started');
            //         this.sanitationProcess3(thirdSanitationIndexes[0], thirdSanitationIndexes[1]);
            //     },900000);

            //     setTimeout(() => {
            //         console.log('process 3 6th sub function started');
            //         this.sanitationProcess3(thirdSanitationIndexes[0], thirdSanitationIndexes[1]);
            //      }, 1080000);

            //     setTimeout(() => {
            //         console.log('process 3 7th sub function started');
            //         this.sanitationProcess3(thirdSanitationIndexes[0], thirdSanitationIndexes[1]);
            //      }, 1260000);
            // }

            // if(typeof this.processRowStartArr[600] !== 'undefined')
            // {
            //     this.sanitationProcess4(fourthSanitationIndexes[0], fourthSanitationIndexes[1]);

            //     setTimeout(() => {
            //         console.log('process 4 1st sub function started');
            //         this.sanitationProcess4(fourthSanitationIndexes[0], fourthSanitationIndexes[1]);
            //     },180000);

            //     setTimeout(() => {
            //         console.log('process 4 2nd sub function started');
            //         this.sanitationProcess4(fourthSanitationIndexes[0], fourthSanitationIndexes[1]);
            //     },360000);

            //     setTimeout(() => {
            //         console.log('process 4 3rd sub function started');
            //         this.sanitationProcess4(fourthSanitationIndexes[0], fourthSanitationIndexes[1]);
            //     },540000);

            //     setTimeout(() => {
            //         console.log('process 4 4th sub function started');
            //         this.sanitationProcess4(fourthSanitationIndexes[0], fourthSanitationIndexes[1]);
            //     },720000);

            //     setTimeout(() => {
            //         console.log('process 4 5th sub function started');
            //         this.sanitationProcess4(fourthSanitationIndexes[0], fourthSanitationIndexes[1]);
            //     },900000);

            //     setTimeout(() => {
            //         console.log('process 4 6th sub function started');
            //         this.sanitationProcess4(fourthSanitationIndexes[0], fourthSanitationIndexes[1]);
            //      }, 1080000);

            //     setTimeout(() => {
            //         console.log('process 4 7th sub function started');
            //         this.sanitationProcess4(fourthSanitationIndexes[0], fourthSanitationIndexes[1]);
            //      }, 1260000);
            // }

            // if(typeof this.processRowStartArr[800] !== 'undefined')
            // {
            //     this.sanitationProcess5(fifthSanitationIndexes[0], fifthSanitationIndexes[1]);

            //     setTimeout(() => {
            //         console.log('process 5 1st sub function started');
            //         this.sanitationProcess5(fifthSanitationIndexes[0], fifthSanitationIndexes[1]);
            //     },180000);

            //     setTimeout(() => {
            //         console.log('process 5 2nd sub function started');
            //         this.sanitationProcess5(fifthSanitationIndexes[0], fifthSanitationIndexes[1]);
            //     },360000);

            //     setTimeout(() => {
            //         console.log('process 5 3rd sub function started');
            //         this.sanitationProcess5(fifthSanitationIndexes[0], fifthSanitationIndexes[1]);
            //     },540000);

            //     setTimeout(() => {
            //         console.log('process 5 4th sub function started');
            //         this.sanitationProcess5(fifthSanitationIndexes[0], fifthSanitationIndexes[1]);
            //     },720000);

            //     setTimeout(() => {
            //         console.log('process 5 5th sub function started');
            //         this.sanitationProcess5(fifthSanitationIndexes[0], fifthSanitationIndexes[1]);
            //     },900000);

            //     setTimeout(() => {
            //         console.log('process 5 6th sub function started');
            //         this.sanitationProcess5(fifthSanitationIndexes[0], fifthSanitationIndexes[1]);
            //      }, 1080000);

            //     setTimeout(() => {
            //         console.log('process 5 7th sub function started');
            //         this.sanitationProcess5(fifthSanitationIndexes[0], fifthSanitationIndexes[1]);
            //      }, 1260000);
            // }

            // if(typeof this.processRowStartArr[1000] !== 'undefined')
            // {
            //     this.sanitationProcess6(sixthSanitationIndexes[0], sixthSanitationIndexes[1]);

            //     setTimeout(() => {
            //         console.log('process 6 1st sub function started');
            //         this.sanitationProcess6(sixthSanitationIndexes[0], sixthSanitationIndexes[1]);
            //     },180000);

            //     setTimeout(() => {
            //         console.log('process 6 2nd sub function started');
            //         this.sanitationProcess6(sixthSanitationIndexes[0], sixthSanitationIndexes[1]);
            //     },360000);

            //     setTimeout(() => {
            //         console.log('process 6 3rd sub function started');
            //         this.sanitationProcess6(sixthSanitationIndexes[0], sixthSanitationIndexes[1]);
            //     },540000);

            //     setTimeout(() => {
            //         console.log('process 6 4th sub function started');
            //         this.sanitationProcess6(sixthSanitationIndexes[0], sixthSanitationIndexes[1]);
            //     },720000);

            //     setTimeout(() => {
            //         console.log('process 6 5th sub function started');
            //         this.sanitationProcess6(sixthSanitationIndexes[0], sixthSanitationIndexes[1]);
            //     },900000);

            //     setTimeout(() => {
            //         console.log('process 6 6th sub function started');
            //         this.sanitationProcess6(sixthSanitationIndexes[0], sixthSanitationIndexes[1]);
            //      }, 1080000);

            //     setTimeout(() => {
            //         console.log('process 6 7th sub function started');
            //         this.sanitationProcess6(sixthSanitationIndexes[0], sixthSanitationIndexes[1]);
            //      }, 1260000);
            // }

            // if(typeof this.processRowStartArr[1200] !== 'undefined')
            // {
            //     this.sanitationProcess7(seventhSanitationIndexes[0], seventhSanitationIndexes[1]);

            //     setTimeout(() => {
            //         console.log('process 7 1st sub function started');
            //         this.sanitationProcess7(seventhSanitationIndexes[0], seventhSanitationIndexes[1]);
            //     },180000);

            //     setTimeout(() => {
            //         console.log('process 7 2nd sub function started');
            //         this.sanitationProcess7(seventhSanitationIndexes[0], seventhSanitationIndexes[1]);
            //     },360000);

            //     setTimeout(() => {
            //         console.log('process 7 3rd sub function started');
            //         this.sanitationProcess7(seventhSanitationIndexes[0], seventhSanitationIndexes[1]);
            //     },540000);

            //     setTimeout(() => {
            //         console.log('process 7 4th sub function started');
            //         this.sanitationProcess7(seventhSanitationIndexes[0], seventhSanitationIndexes[1]);
            //     },720000);

            //     setTimeout(() => {
            //         console.log('process 7 5th sub function started');
            //         this.sanitationProcess7(seventhSanitationIndexes[0], seventhSanitationIndexes[1]);
            //     },900000);

            //     setTimeout(() => {
            //         console.log('process 7 6th sub function started');
            //         this.sanitationProcess7(seventhSanitationIndexes[0], seventhSanitationIndexes[1]);
            //      }, 1080000);

            //     setTimeout(() => {
            //         console.log('process 7 7th sub function started');
            //         this.sanitationProcess7(seventhSanitationIndexes[0], seventhSanitationIndexes[1]);
            //      }, 1260000);
            // }

            // if(typeof this.processRowStartArr[1400] !== 'undefined')
            // {
            //     this.sanitationProcess8(eightSanitationIndexes[0], eightSanitationIndexes[1]);

            //     setTimeout(() => {
            //         console.log('process 8 1st sub function started');
            //         this.sanitationProcess8(eightSanitationIndexes[0], eightSanitationIndexes[1]);
            //     },180000);

            //     setTimeout(() => {
            //         console.log('process 8 2nd sub function started');
            //         this.sanitationProcess8(eightSanitationIndexes[0], eightSanitationIndexes[1]);
            //     },360000);

            //     setTimeout(() => {
            //         console.log('process 8 3rd sub function started');
            //         this.sanitationProcess8(eightSanitationIndexes[0], eightSanitationIndexes[1]);
            //     },540000);

            //     setTimeout(() => {
            //         console.log('process 8 4th sub function started');
            //         this.sanitationProcess8(eightSanitationIndexes[0], eightSanitationIndexes[1]);
            //     },720000);

            //     setTimeout(() => {
            //         console.log('process 8 5th sub function started');
            //         this.sanitationProcess8(eightSanitationIndexes[0], eightSanitationIndexes[1]);
            //     },900000);

            //     setTimeout(() => {
            //         console.log('process 8 6th sub function started');
            //         this.sanitationProcess8(eightSanitationIndexes[0], eightSanitationIndexes[1]);
            //      }, 1080000);

            //     setTimeout(() => {
            //         console.log('process 8 7th sub function started');
            //         this.sanitationProcess8(eightSanitationIndexes[0], eightSanitationIndexes[1]);
            //      }, 1260000);
            // }

            // if(typeof this.processRowStartArr[1600] !== 'undefined')
            // {
            //     this.sanitationProcess9(nineSanitationIndexes[0], nineSanitationIndexes[1]);

            //     setTimeout(() => {
            //         console.log('process 9 1st sub function started');
            //         this.sanitationProcess9(nineSanitationIndexes[0], nineSanitationIndexes[1]);
            //     },180000);

            //     setTimeout(() => {
            //         console.log('process 9 2nd sub function started');
            //         this.sanitationProcess9(nineSanitationIndexes[0], nineSanitationIndexes[1]);
            //     },360000);

            //     setTimeout(() => {
            //         console.log('process 9 3rd sub function started');
            //         this.sanitationProcess9(nineSanitationIndexes[0], nineSanitationIndexes[1]);
            //     },540000);

            //     setTimeout(() => {
            //         console.log('process 9 4th sub function started');
            //         this.sanitationProcess9(nineSanitationIndexes[0], nineSanitationIndexes[1]);
            //     },720000);

            //     setTimeout(() => {
            //         console.log('process 9 5th sub function started');
            //         this.sanitationProcess9(nineSanitationIndexes[0], nineSanitationIndexes[1]);
            //     },900000);

            //     setTimeout(() => {
            //         console.log('process 9 6th sub function started');
            //         this.sanitationProcess9(nineSanitationIndexes[0], nineSanitationIndexes[1]);
            //      }, 1080000);

            //     setTimeout(() => {
            //         console.log('process 9 7th sub function started');
            //         this.sanitationProcess9(nineSanitationIndexes[0], nineSanitationIndexes[1]);
            //      }, 1260000);
            // }

            // if(typeof this.processRowStartArr[1800] !== 'undefined')
            // {
            //     this.sanitationProcess10(tenthSanitationIndexes[0], tenthSanitationIndexes[1]);

            //     setTimeout(() => {
            //         console.log('process 10 1st sub function started');
            //         this.sanitationProcess10(tenthSanitationIndexes[0], tenthSanitationIndexes[1]);
            //     },180000);

            //     setTimeout(() => {
            //         console.log('process 10 2nd sub function started');
            //         this.sanitationProcess10(tenthSanitationIndexes[0], tenthSanitationIndexes[1]);
            //     },360000);

            //     setTimeout(() => {
            //         console.log('process 10 3rd sub function started');
            //         this.sanitationProcess10(tenthSanitationIndexes[0], tenthSanitationIndexes[1]);
            //     },540000);

            //     setTimeout(() => {
            //         console.log('process 10 4th sub function started');
            //         this.sanitationProcess10(tenthSanitationIndexes[0], tenthSanitationIndexes[1]);
            //     },720000);

            //     setTimeout(() => {
            //         console.log('process 10 5th sub function started');
            //         this.sanitationProcess10(tenthSanitationIndexes[0], tenthSanitationIndexes[1]);
            //     },900000);

            //     setTimeout(() => {
            //         console.log('process 10 6th sub function started');
            //         this.sanitationProcess10(tenthSanitationIndexes[0], tenthSanitationIndexes[1]);
            //      }, 1080000);

            //     setTimeout(() => {
            //         console.log('process 10 7th sub function started');
            //         this.sanitationProcess10(tenthSanitationIndexes[0], tenthSanitationIndexes[1]);
            //      }, 1260000);
            // }

        },
        sanitationProcessOneParent: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 1,
                index: indexStart,
                sanitationWorker1: this.sanitationWorker1
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;


                this.sanitationWorker1 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcessOneParent(nextIndex, indexStop);
                    }
                }else
                {
                    console.log('Sanitation Worker 1: '+this.sanitationWorker1);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess1(indexStart, indexStop);
            })
        },
        sanitationProcessOneChild: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 1,
                index: indexStart,
                sanitationWorker1: this.sanitationWorker1
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;


                this.sanitationWorker1 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcessOneChild(nextIndex, indexStop);
                    }
                }else
                {
                    console.log('Sanitation Worker 1: '+this.sanitationWorker1);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess1(indexStart, indexStop);
            })
        },
        sanitationProcess2: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 2,
                index: indexStart,
                sanitationWorker2: this.sanitationWorker2
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;

                this.sanitationWorker2 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcess2(nextIndex, indexStop);
                    }
                }else
                {
                    console.log('Sanitation Worker 2: '+this.sanitationWorker2);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess2(indexStart, indexStop);
            })
        },
        sanitationProcess3: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 3,
                index: indexStart,
                sanitationWorker3: this.sanitationWorker3
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;

                this.sanitationWorker3 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcess3(nextIndex, indexStop);
                    }
                }else
                {
                     console.log('Sanitation Worker 3: '+this.sanitationWorker3);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess3(indexStart, indexStop);
            })
        },
        sanitationProcess4: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 4,
                index: indexStart,
                sanitationWorker4: this.sanitationWorker4
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;

                this.sanitationWorker4 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcess4(nextIndex, indexStop);
                    }
                }else
                {
                     console.log('Sanitation Worker 4: '+this.sanitationWorker4);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess4(indexStart, indexStop);
            })
        },
        sanitationProcess5: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 5,
                index: indexStart,
                sanitationWorker5: this.sanitationWorker5
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;

                this.sanitationWorker5 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcess5(nextIndex, indexStop);
                    }
                }else
                {
                     console.log('Sanitation Worker 5: '+this.sanitationWorker5);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess5(indexStart, indexStop);
            })
        },
        sanitationProcess6: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 6,
                index: indexStart,
                sanitationWorker6: this.sanitationWorker6
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;

                this.sanitationWorker6 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                            this.sanitationProcess6(nextIndex, indexStop);
                    }else
                    {
                        console.log('Sanitation Worker 6 '+this.sanitationWorker6);
                    }
                }else
                {
                     console.log('Sanitation Worker 6 '+this.sanitationWorker6);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess6(indexStart, indexStop);
            })
        },
        sanitationProcess7: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 7,
                index: indexStart,
                sanitationWorker7: this.sanitationWorker7
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;

                this.sanitationWorker7 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;


                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                            this.sanitationProcess7(nextIndex, indexStop);
                    }else
                    {
                        console.log('Sanitation Worker 7 '+this.sanitationWorker7);
                    }
                }else
                {
                    console.log('Sanitation Worker 7 '+this.sanitationWorker7);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess7(nextIndex, indexStop);
            })
        },
        sanitationProcess8: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 8
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;

                this.sanitationWorker8 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;


                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcess8(nextIndex, indexStop);
                    }else
                    {
                        console.log('Sanitation Worker 8 '+this.sanitationWorker8);
                    }
                }else
                {
                    console.log('Sanitation Worker 8 '+this.sanitationWorker8);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess8(indexStart, indexStop);
            })
        },
        sanitationProcess9: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 9
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;

                this.sanitationWorker9 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcess9(nextIndex, indexStop);
                    }else
                    {
                        console.log('Sanitation Worker 9 '+this.sanitationWorker9);
                    }
                }else
                {
                    console.log('Sanitation Worker 9 '+this.sanitationWorker9);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess9(indexStart, indexStop);
            })
        },
        sanitationProcess10: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 10
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / this.totalSanitationProcess) * 100;

                this.sanitationWorker10 += this.rowsPerSanitationProcess;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcess10(nextIndex, indexStop);
                    }else
                    {
                        console.log('Sanitation Worker 10 '+this.sanitationWorker10);
                    }
                }else
                {
                    console.log('Sanitation Worker 10 '+this.sanitationWorker10);
                }
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess10(indexStart, indexStop);
            })
        },
        initialData:function()
        {
            axios.get(`sanitation/sanitized-total`)
            .then((response) =>
            {
                let resp = response.data;
                this.rowCount = (resp.totalRaw - resp.totalSanitized);
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalSanitationProcess = resp.totalRaw;
                this.totalUnsanitizedRow = (resp.totalRaw - resp.totalSanitized);
            })
            .catch((error) =>
            {
                console.log(error);
            })
        }
    }
});