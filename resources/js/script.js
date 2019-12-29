var progressWidth = 0;

window.progressBar = function progressBar(startTime, endTime) {
    let now = new Date();

    startTime = getTime(startTime).valueOf();
    endTime = getTime(endTime).valueOf();
    progressWidth = Math.round(((now - startTime)/(endTime - startTime)) * 100);
    progressWidth =  progressWidth > 100 ? 100 : progressWidth;
    setProgress();
    startEvent(startTime, endTime);
}

window.addEventListener('load',
function() {
    alert("heello");
    console.log(document.getElementById('selected-action').selectedIndex);
    if(document.getElementById('selected-action').selectedIndex === 1) {
        document.getElementById('moved-to-control').style.display = 'none';
    }
}, false);

function getTime(time)
{
    let date = new Date();
    let res = time.split(':');
    return new Date(date.getFullYear(), date.getMonth(), date.getDate(), parseInt(res[0]), parseInt(res[1]));
}

function startEvent (start, end)
{
    const int = setInterval(() => {
        const now = (new Date()).valueOf();
        if (now >= end) {
            progressWidth = 100;
            clearInterval(int); return;
        };
        progressWidth = Math.round(((now - start)/(end - start)) * 100);
        setProgress();
    }, 10000)
}

function setProgress()
{
    document.querySelector(".progress-bar").style.width = progressWidth + '%';
}
