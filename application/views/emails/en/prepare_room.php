<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <body>
        <h3>{Title}</h3>
        Dear {CreatorName}, <br />
        <br />
        The booking you've requested has been rejected because the room in instruction. Below, the details :
        <table border="0">
            <tr>
                <td>From &nbsp;</td><td>{StartDate}</td>
            </tr>
            <tr>
                <td>To &nbsp;</td><td>{EndDate}</td>
            </tr>    
             <tr>
                <td>Room &nbsp;</td><td>{RoomName}</td>
            </tr>
            <tr>
                <td>Location &nbsp;</td><td>{LocationName}</td>
            </tr>
        </table>
    </body>
</html>
