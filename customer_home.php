<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="customer_home.css">
    <title>ByteSize Delights</title>
</head>

<body>
    <!-- Navigation bar -->
    <nav>
        <div class="navigationBar">
            <div class="navigationLogo">
                <img src="images/navigationBarLogo.png" alt="Small ByteSize Logo">
            </div>
            <div class="navButton">
                <ul class="navigationContents">
                    <h1>|</h1>
                    <li><a href="#customer_home.html" class="activeNav";>Home</a></li>
                    <h1>|</h1>
                    <li><a href="#">Products</a></li>
                    <h1>|</h1>
                    <li><a href="#Faqs.html" class="activeNav";>FAQs</a></li>
                    <h1>|</h1>
                </ul>
            </div>
            <div class="userAccountNavigationSection">
                <img src="images/userIcon.png" id="userPopUp" alt="User Icon">
            </div>
        </div>
    </nav>

    <div class="accountDropDown">
      <p class="welcomeUser">Welcome!</p>
      <div class="logOutSection">
        <a href="#">Log Out</a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" id="logout">
          <path fill="#ff69a0" fill-rule="evenodd" d="M3 13H15V11H3V13Z" clip-rule="evenodd" class="color90caea svgShape"></path>
          <path fill="#ff69a0" fill-rule="evenodd" d="M5.79282 7.79291L2.29282 11.2929C1.90229 11.6834 1.90229 12.3166 2.29282 12.7071L5.79282 16.2071L7.20703 14.7929L4.41414 12L7.20703 9.20712L5.79282 7.79291Z" clip-rule="evenodd" class="color90caea svgShape"></path>
          <path fill="#2e222f" fill-rule="evenodd" d="M8 4C8 3.44772 8.44772 3 9 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H9C8.44772 21 8 20.5523 8 20V17H10V19H20V5H10V7H8V4Z" clip-rule="evenodd" class="color3747d6 svgShape"></path>
        </svg>
      </div>
    </div>

    <main>
      <!-- Banner -->
      <div class="Banner-Wrapper">
          <div class="bannerSection">
            <img src="images/bannerBackground.png" class="bannerBg">
            
            <div class="starsBanner" id="starsBanner"></div>
        
            <div class="bannerLogoAndQuote">
            <div class="bannerLogo">
              <img src="images/bannerLogo.png" alt="Banner Logo">
            </div>

            <div class="bannerQuote">
              <div class="bannerQuoteGroup">
                <span>Where</span>
                <span>every</span>
                <span>bite</span>
                <span>makes</span>
                <span>big</span>
                <span>smiles</span>
              </div>
            </div>
          </div>

            <div class="bannerMascots">
              <img src="images/cookieTwo.png" alt="Cookie Mascot 2" class="cookieMascotLeft">
              <img src="images/pastillasTwo.png" alt="Pastillas Mascot2" class="pastillasMascotLeft">
              <img src="images/grahamThree.png" alt="Graham Balls Mascot 3" class="grahamMascotLeft">
              <img src="images/pastillasOne.png" alt="Pastillas Mascot 1" class="pastillasMascotRight">
              <img src="images/grahamTwo.png" alt="Graham Balls Mascot 2" class="grahamMascotRight">
              <img src="images/cookieThree.png" alt="Cookie Mascot 2" class="cookieMascotRight">
            </div>

          </div>
        </div>

      <!-- Dynamic Product Description-->

      <div class="ourProductsHeader animated">
          <p>Our Products</p>
      </div>

      <div class="Product-Description-Main-Wrapper animated">
          <div class="Description-Wrap">
              <button class="arrow left">&#10094;</button>
              <div class="Product-Description">
                  <div class="Description Product-1">
                    <img src="Homepage/cookiesTreats.png" alt="Cookies">
                    <p>Freshly baked and decadently chewy cookies in the flavors Chocolate and Red velvet that are irresistible in every byte!</p>
                    <button>Order Now</button>
                  </div>
                  <div class="Description Product-2">
                    <img src="Homepage/pastillasTreats.png" alt="Pastillas">
                    <p>This melt in your mouth, byte-sized desserts in different unique variations will surely be addictive in every byte!</p>
                    <button>Order Now</button>
                  </div>
                  <div class="Description Product-3">
                    <img src="Homepage/grahamTreats.png" alt="Graham Balls">
                    <p>Indulgent sweet balls of crushed graham filled with different flavored marshmallows, offering various textures in every bite!</p>
                    <button>Order Now</button>
                  </div>
              </div>
          <button class="arrow right">&#10095;</button>
          </div>
          
          <!-- Description Mascots -->
          <div class="Mascot-Wrap">
              <div class="Product-Mascots">
                  <div class="Mascot Cookie" data-index="1">
                      <img src="HomePage/Cookie Mascot.png" alt="">
                  </div>
                  <div class="Mascot Pastillas" data-index="2">
                      <img src="HomePage/Pastillias Mascot.png" alt="">
                  </div>
                  <div class="Mascot Graham"  data-index="3">
                      <img src="HomePage/GrahamBall Mascot.png" alt="">
                  </div>
              </div>
          </div>
      </div>

      <div class="triviaSection">
        <p class="triviaTitleHeader">The ByteSize Story</p>
        <p class="triviaDescriptionHeader">From our kitchen to your home — your love for our treats made this dream possible! Every pastillas, graham ball, and cookie we've made has been shaped by your cravings!</p>

        <div class="allFacts">
        <div class="factOneContainer">
          <img src="images/cookieTwo.png" alt="Cookie Mascot 2" class="factOneMascot bounceElement">
          <div class="factOne">
            <img src="images/factOnePicture.png" alt="Files">
            <p class="triviaTitle">From Syntax to Snacks</p>
            <p class="triviaDescription">Started by three UST students from the CICS department! From group chats to group orders, ByteSize Delights is proof that techies can bake, too!</p>
          </div>
        </div>

        <div class="factTwoContainer">
          <img src="images/pastillasOne.png" alt="Pastillas Mascot 2" class="factTwoMascot">
          <div class="factTwo">
            <img src="images/factTwoPicture.png" alt="Partnership">
            <p class="triviaTitle">Delightful Partnerships</p>
            <p class="triviaDescription">ByteSize Delights has proudly had the pleasure of sponsoring UST events, sharing the sweetness with Thomasians every step of the way!</p>
          </div>
        </div>

        <div class="factThreeContainer">
          <img src="images/grahamThree.png" alt="Graham Mascot 3" class="factThreeMascot bounceElement">
          <div class="factThree">
            <img src="images/factThreePicture.png" alt="Packages">
            <p class="triviaTitle">100 packs, 100 smiles</p>
            <p class="triviaDescription">Every month, ByteSize Delights sends out around 100 packs of joy. Your cravings fuel our passion for baking and sharing the best!</p>
          </div>
        </div>

        <div class="factFourContainer">
          <img src="images/cookieThree.png" alt="Cookie Mascot 3" class="factFourMascotOne">
          <img src="images/pastillasTwo.png" alt="Pastillas Mascot 2" class="factFourMascotTwo">
          <img src="images/grahamTwo.png" alt="Graham Mascot 2" class="factFourMascotThree">
          <div class="factFour">
            <img src="images/factFourPicture.png" alt="Japan, Australia, Canada Flag">
            <p class="triviaTitle">ByteSize Goes Global</p>
            <p class="triviaDescription">ByteSize Delights has shipped packages all the way to Japan, Australia, and Canada,  bringing a taste of the Philippines to new corners of the world!</p>
          </div>
        </div>
      </div>
      </div>

      <div class="missionSection">
        <div class="missionLeft">
          <p class="missionHeader">Mission</p>
          <div class="missionDescriptionMascots">
            <p class="missionDescription">Our mission is to expand ByteSize Delights into new communities, Serving as a guiding light for aspiring bakers, especially student bakers like us, in launching their own dessert businesses. Our goal is to offer delicious sweets while simultaneously showcasing creativity in the baking world.</p>
            <img src="images/pastillasTwo.png" alt="Pastillas Mascot">
          </div>
          </div>
        <div class="missionRight">
          <div class="missionPicturesTop">
            <img src="images/missionPictureOne.jpg" alt="Customer Pictures" class="missionPictureOne">
            <img src="images/missionPictureTwo.jpg" alt="Customer Pictures" class="missionPictureTwo">
          </div>
          <div class="missionPictureBottom">
            <img src="images/missionPictureThree.jpg" alt="Customer Pictures" class="missionPictureThree">
          </div>
        </div>
      </div>

      <div class="visionSection">
        <img src="images/visionPicture.jpg" alt="Customer Picture" class="visionPicture">
        <div class="visionRight">
          <p class="visionHeader">Vision</p>
          <div class="visionDescriptionMascots">
            <p class="visionDescription">At ByteSize Delights, a community-centered company, we want to make it possible for everyone, especially students, to enjoy tasty, affordable bite-sized delights that satisfy cravings without burning a hole in their wallets.</p>
            <img src="images/cookieThree.png" alt="Cookie Mascot">
          </div>
        </div>
      </div>
     </main>


     <footer>
      <svg class="wave" id="wave" style="transform:rotate(180deg); transition: 0.3s" viewBox="0 0 1440 260" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(255, 192, 203, 1)" offset="0%"></stop><stop stop-color="rgba(255, 192, 203, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,26L10.9,56.3C21.8,87,44,147,65,143C87.3,139,109,69,131,52C152.7,35,175,69,196,108.3C218.2,147,240,191,262,182C283.6,173,305,113,327,82.3C349.1,52,371,52,393,47.7C414.5,43,436,35,458,60.7C480,87,502,147,524,182C545.5,217,567,225,589,203.7C610.9,182,633,130,655,121.3C676.4,113,698,147,720,147.3C741.8,147,764,113,785,108.3C807.3,104,829,130,851,138.7C872.7,147,895,139,916,147.3C938.2,156,960,182,982,199.3C1003.6,217,1025,225,1047,190.7C1069.1,156,1091,78,1113,60.7C1134.5,43,1156,87,1178,91C1200,95,1222,61,1244,60.7C1265.5,61,1287,95,1309,130C1330.9,165,1353,199,1375,195C1396.4,191,1418,147,1440,125.7C1461.8,104,1484,104,1505,108.3C1527.3,113,1549,121,1560,125.7L1570.9,130L1570.9,260L1560,260C1549.1,260,1527,260,1505,260C1483.6,260,1462,260,1440,260C1418.2,260,1396,260,1375,260C1352.7,260,1331,260,1309,260C1287.3,260,1265,260,1244,260C1221.8,260,1200,260,1178,260C1156.4,260,1135,260,1113,260C1090.9,260,1069,260,1047,260C1025.5,260,1004,260,982,260C960,260,938,260,916,260C894.5,260,873,260,851,260C829.1,260,807,260,785,260C763.6,260,742,260,720,260C698.2,260,676,260,655,260C632.7,260,611,260,589,260C567.3,260,545,260,524,260C501.8,260,480,260,458,260C436.4,260,415,260,393,260C370.9,260,349,260,327,260C305.5,260,284,260,262,260C240,260,218,260,196,260C174.5,260,153,260,131,260C109.1,260,87,260,65,260C43.6,260,22,260,11,260L0,260Z"></path></svg>

    <div class="Footer-Content">
      <div class="F-logo">
        <img src="HomePage/FooterLogo.png" alt="">
      </div>
      <div class="F-Details">
        <div class="Detail D1">
          <a href="">Home</a>
          <ul>
            <li>Our Products</li>
            <li>ByteSize Story</li>
            <li>Mission</li>
            <li>Vision</li>
          </ul>
        </div>
        
        <div class="Detail D2">
          <a href="">Products</a>
          <ul>
            <li>Services</li>
            <li>Supports</li>
            <li>Terms & Condition</li>
            <li>Privacy Policy</li>
          </ul>
        </div>
        <div class="Detail D3">
          <a href="">Services</a>
          <ul>
            <li>Menu</li>
            <li>Order</li>
          </ul>
          </div>
      </div>
      <div class="RightFooter">
        <div class="F-Mascots">
          <div class="FM M1"><img src="HomePage/Cookie Mascot.png"></div>
          <div class="FM M2"><img src="HomePage/Pastillias Mascot.png"></div>
          <div class="FM M3"><img src="HomePage/GrahamBall Mascot.png"></div>
        </div>
        <div class="F-Socials">
          <p class="Contact">Contact Us:</p>
          <div class="SocialIcons Gmail">
            <a href=""><img src="Footer/gmail.svg"></a>
            <p>bytesizedelights@Gmail.com</p>
          </div>
            <div class="SocialIcons Facebook">
              <a href="https://www.facebook.com/profile.php?id=61555877165065" target="_blank"><img src="Footer/facebook.svg"></a>
              <p>ByteSize Delights</p>
            </div>
            <div class="SocialIcons Instagram">
              <a href="https://www.instagram.com/bytesize.delights?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank"><img src="Footer/instagram.svg"></a>
              <p>@bytesizedelights</p>
            </div>
        </div> 
      </div>
    </div>
  </footer>
</body>

<script>
    //Dito sa html file nyo ilagay lahat ng dynamic effects wag na muna mag separate Js. file 


    // for banner twinkle star effect
    const starsContainer = document.getElementById('starsBanner');
    const maxHeight = window.innerHeight;

    for (let i = 0; i < 150; i++) {
        const span = document.createElement('span');
        span.classList.add('star');

        // Left stays as a percentage
        span.style.left = Math.random() * 100 + '%';

        // Top between 60px and 100% of the page height
        const topPx = 60 + Math.random() * (maxHeight - 60);
        span.style.top = topPx + 'px';

        span.style.animationDelay = (Math.random() * 10).toFixed(1) + 's';

        span.innerHTML = '<i class="fa fa-star"></i>';
        starsContainer.appendChild(span);
    }

    // for banner fade effect
    const Banner = document.querySelector('.Banner-Wrapper');

    window.addEventListener('scroll', () => {
    const scrollPosition = window.scrollY;
    const fadeOutPoint = 350; 
    Banner.style.opacity = Math.max(1 - scrollPosition   / fadeOutPoint, 0);
    });

    // for Dynamic Product Description
    const mascots = document.querySelectorAll('.Mascot');
    const descriptions = document.querySelectorAll('.Description');
    const leftArrow = document.querySelector('.arrow.left');
    const rightArrow = document.querySelector('.arrow.right');

    function rotateIndexes(direction) {
      mascots.forEach(mascot => {
        let index = parseInt(mascot.dataset.index);

        if (direction === 'right') {
          index = index - 1 < 1 ? 3 : index - 1;
        } else {
          index = index + 1 > 3 ? 1 : index + 1;
        }

        mascot.setAttribute('data-index', index);
      });

      updateDescription(getActiveIndex());
    }

    // get index of mascot with data-index="1"
    function getActiveIndex() {
      const activeMascot = Array.from(mascots).find(m => m.dataset.index === "1");
      const classList = activeMascot.classList;
      if (classList.contains("Cookie")) return 0;
      if (classList.contains("Pastillas")) return 1;
      if (classList.contains("Graham")) return 2;
      return 0; // rereturn sa unang container
    }

    // Update description 
    function updateDescription(index) {
      descriptions.forEach((desc, i) => {
        desc.classList.toggle("active", i === index);
      });
    }

    // Arrow controls
    leftArrow.addEventListener('click', () => {
      rotateIndexes('left');
    });

    rightArrow.addEventListener('click', () => {
      rotateIndexes('right');
    });

    // Active Currest state niya
    updateDescription(getActiveIndex());

    document.addEventListener('DOMContentLoaded', () => {
        const elements = document.querySelectorAll('.bounceElement');
      
        const observer = new IntersectionObserver(entries => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('active');
            }
          });
        }, {
          threshold: 0.5 // Adjust this if needed
        });
      
        elements.forEach(el => observer.observe(el));
      });

    // log out drop down
  const userIcon = document.getElementById("userPopUp");
  const accountDropDown = document.querySelector(".accountDropDown");

  userIcon.addEventListener("click", () => {
    if (accountDropDown.style.visibility === "visible") {
      accountDropDown.style.visibility = "hidden";
    } else {
      accountDropDown.style.visibility = "visible";
    }
  });

  userIcon.addEventListener("click", () => {
  accountDropDown.classList.toggle("visible");
});



</script>

</html>