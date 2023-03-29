<style>
    #clock span {
  line-height: 0.8em;
}

#date span {
  line-height: 1em;
}

#clock {
    padding-top: 8px;
    padding-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5em;
    font-weight: bold;
    margin-bottom: 20px; /* add margin-bottom to create space between #time and #date */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

#date {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4em;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}


#hours {
  /* font-size: 2em; */
  border-radius: 10px;
  color: #333;
}

#minutes {
  /* font-size: 2em; */
  border-radius: 10px;
  color: #666;
}

#ampm {
  /* font-size: 2em; */
  border-radius: 10px;
  color: #ffffff;
  margin-left: 2px;
}

#weekday {
  font-size: 1.5em;
  color: #999;
}

#month {
  font-size: 1.5em;
  color: #999;
}

#day {
  font-size: 2.5em;
  color: #333;
}

#year {
  font-size: 1.5em;
  color: #999;
}
</style>

<div class="m-0" id="clock">
    <span  id="hours"></span>
    <span>:</span>
    <span id="minutes"></span>
    <span class="bg-dark p-1" id="ampm"></span>
</div>
<div class="p-1" id="date">
    <span id="weekday"></span>
    <span>, </span>
    <span id="month"></span>
    <span> </span>
    <span id="day"></span>
    <span>, </span>
    <span id="year"></span>
</div>
