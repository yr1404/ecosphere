const hamburger = document.querySelector('.bars');
// console.log(hamburger);
const navLink = document.querySelector('.navbar');

hamburger.onclick = function () {
    navLink.classList.toggle("active");

    const anchorTags = navLink.getElementsByTagName('a');

    for (let i = 0; i < anchorTags.length; i++) {
        anchorTags[i].onclick = function () {
            navLink.classList.toggle("active");
        };
    }
}

//Scroll to top button visibility changes with scrolling
const scrollToTopButton = document.getElementsByClassName("scroll-to-top")[0];
const serviceSection = document.getElementById("about");

window.addEventListener("scroll", () => {
    if (window.innerWidth < 1240) {
        if (window.pageYOffset > 675) {
            scrollToTopButton.style.scale = "1";
        }
        else {
            scrollToTopButton.style.scale = "0";
        }
    }
    else if (window.pageYOffset > 200) {
        scrollToTopButton.style.scale = "1";
    }
    else {
        scrollToTopButton.style.scale = "0";
    }
});



// Drag fubction for sub-text

// var dragValue;

// function drag(id) {
//     var elem = document.getElementById("sub-text");
//     elem.style.position = "absolute";
//     elem.onmousedown = function() {
//         dragValue = elem;
//     }
// }
// document.onmousemove = function (e) {
//     let x = e.pageX;
//     let y = e.pageY;

//     dragValue.style.left = x + "px";
//     dragValue.style.top = y + "px";
// }

$(function () {
    $("#sub-text").draggable({
        revert: true
    });
});


// Testimonial slider

// setInterval(function removeLastElement() {
//     var reviews = document.getElementsByClassName('testimonial-slider')[0];
//     var firstElement = document.getElementsByClassName('review')[0]
//     reviews.scrollBy(400,0)
//     setTimeout(1000)
//     reviews.appendChild(firstElement)
//     reviews.removeChild(firstElement)
// }, 2000);

const reviewsContainer = document.querySelector('.testimonial-slider');
const reviews = document.querySelectorAll('.review');

// Duplicates the reviews for the infinite sliding effect
reviews.forEach((review) => {
    const clone = review.cloneNode(true);
    reviewsContainer.appendChild(clone);
});

// Sets the width of the reviews container to accommodate all reviews
reviewsContainer.style.width = `${reviews.length * 100}%`;

let currentIndex = 0;

function nextReview() {
    currentIndex++;
    if (currentIndex < reviews.length) {
        // Move to the next review
        const reviewWidth = reviews[currentIndex].offsetWidth + 20; // considering margin
        reviewsContainer.style.transform = `translateX(-${reviewWidth * currentIndex}px)`;
    } else {
        // Move back to the first review
        currentIndex = 0;
        reviewsContainer.style.transform = 'translateX(0)';
    }
}

// Automatically move to the next review in a fixed interval
setInterval(nextReview, 3000);


//circle following cursor

const contact = document.getElementById("contact-us");
var cursor = document.getElementById("cursor");

contact.addEventListener('mouseenter', () => {
    cursor.style.opacity = 1;
});

contact.addEventListener('mouseleave', () => {
    cursor.style.opacity = 0;
});

document.addEventListener('mousemove', (e) => {
    const x = e.clientX;
    const y = e.clientY;

    cursor.style.transform = `translate(${x - 58}px, ${y - 485}px)`;
})


// Displaying sandbox connection pop up onclick of the checkbox

const checkb = document.getElementById("wa-checkbox")
var newDiv = document.getElementsByClassName("wa-popup-container")[0]
const contactDiv = document.getElementById("contact-us")
// const overlay = $('#contact-us')
// overlay.scrollableOverlay()

checkb.addEventListener("click", () => {

    if (checkb.checked == true) {
        // contactDiv.style.overflowY = 'scroll';
        document.body.style.overflowY = 'hidden'
        newDiv.style.display = "flex";
        newDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        newDiv.style.display = "none";
    }

})

// http://wa.me/+14155238886?text=join%20direct-poetry
function closeDiv() {
    newDiv.style.display = "none";
    document.body.style.overflowY = 'scroll'
    // contactDiv.style.overflow = 'scroll';
}

// php fetch
document.getElementById("git-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission

    // Extract form data
    const formData = new FormData(this);

    // Send to first endpoint
    fetch("connect.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text())
    .then(data => console.log("Response from connect.php:", data))
    .catch(error => console.error("Error:", error));

    // Send to second endpoint
    fetch("https://es-php-db.rf.gd/db.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text())
    .then(data => console.log("Response from db.php:", data))
    .catch(error => console.error("Error:", error));
});