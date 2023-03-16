import fetch, { Headers} from "node-fetch"
const headers=new Headers()

const ourPassword="auPK flun iruo BPN5 OZJt 2RNN"
const ourUserName="simon"

headers.set("Content-Type", "application/json")
headers.set("Authorization", "Basic "+ Buffer.from(`${ourUserName}:${ourPassword}`).toString("base64"))

window.onload = function () {
    console.log("Cargado respAPI functions");
    var buttonInsert=document.getElementById("submit");
    buttonInsert.addEventListener("click", function(){
       /* fetch("https://blog.audiotours.es/wp-json/wp/v2/posts", {
            method:"POST",
            headers:{
                "Content-Type":"application/json",
                "X-WP-Nonce":myData.nonce
            },
            body: JSON.stringify({
                title:"blog creado con cookies",
                content:"this is amazing content",
                status:"publish"
            })
        })*/

        fetch("https://blog.audiotours.es/wp-json/wp/v2/posts", {
            method:"POST",
            headers: headers,
            body: JSON.stringify({
                title:"blog creado con Contraseñas de aplicacion",
                content:"<!-- wp:paragraph -->bieeeeeen.<!-- /wp:paragraph  -->",
                status:"publish"
            })
        })
    });
}