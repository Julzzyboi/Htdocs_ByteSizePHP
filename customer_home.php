<!-- <?php
session_start();

// if (!isset($_SESSION['user_ID'])) {
//   header("Location: Account.php");
//   exit();
// }


?> -->
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
              <input type="checkbox" class="toggleMenu">
              <div class="hamburger"></div>
                <ul class="navigationContents">
                    <p class="menuNav">Menu</p>
                    <h1 class="divider">|</h1>
                    <div class="homeNavContainer">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="home">
                        <path fill="#ff69a0" d="M14,6.76l-.89,7.34c-.06.51-.49.9-.99.9H3.88c-.5,0-.93-.39-.99-.9l-.89-7.34L7.29,1.3c.39-.4,1.03-.4,1.42,0l5.29,5.46Z" class="colora880ff svgShape"></path>
                        <path d="M15.3584,7.4419l-.9974-1.0276c-.0007-.0008-.0009-.0019-.0016-.0027L9.0684.9507c-.5664-.5811-1.5693-.582-2.1377.001L1.6406,6.4116c-.0007.0008-.0009.0019-.0016.0027l-.9974,1.0276c-.1924.1982-.1885.5146.0098.707.0977.0942.2227.1411.3486.1411.1309,0,.2607-.0508.3584-.1519l.2714-.2797.7637,6.3007c.0908.7642.7295,1.3408,1.4863,1.3408h8.2402c.7568,0,1.3955-.5767,1.4863-1.3398l.7637-6.3016.2714.2796c.0977.1011.2275.1519.3584.1519.126,0,.251-.0469.3486-.1411.1982-.1924.2021-.5088.0098-.707ZM12.6143,14.041c-.0312.2573-.248.459-.4941.459H3.8799c-.2461,0-.4629-.2017-.4941-.46l-.8604-7.1035L7.6484,1.6489c.1855-.1924.5186-.1914.7021-.001l5.124,5.2886-.8604,7.1045Z" fill="#2e222f" class="color000000 svgShape"></path>
                        <path d="M8 11.5c-1.3789 0-2.5-1.1216-2.5-2.5s1.1211-2.5 2.5-2.5 2.5 1.1216 2.5 2.5-1.1211 2.5-2.5 2.5zM8 7.5c-.8271 0-1.5.6729-1.5 1.5s.6729 1.5 1.5 1.5 1.5-.6729 1.5-1.5-.6729-1.5-1.5-1.5zM10 13.5h-4c-.2764 0-.5-.2236-.5-.5s.2236-.5.5-.5h4c.2764 0 .5.2236.5.5s-.2236.5-.5.5z" fill="#2e222f" class="color000000 svgShape"></path>
                      </svg>
                      <li><a href="#customer_home.html" class="activeNav homeNav">Home</a></li>
                    </div>
                    <h1 class="divider">|</h1>

                    <div class="productsNavContainer">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" id="Candy">
                        <rect width="14" height="24" x="25" y="20" fill="#f3216e" rx="7" ry="7" transform="rotate(45 32 32)" class="colorf37121 svgShape"></rect>
                        <path fill="#ff69a0" d="M36.314,16.686h14a0,0,0,0,1,0,0v5a3,3,0,0,1-3,3h-8a3,3,0,0,1-3-3v-5a0,0,0,0,1,0,0Z" transform="rotate(45 43.314 20.686)" class="colorffbd69 svgShape"></path>
                        <path fill="#ff69a0" d="M16.686,39.314h8a3,3,0,0,1,3,3v5a0,0,0,0,1,0,0h-14a0,0,0,0,1,0,0v-5A3,3,0,0,1,16.686,39.314Z" transform="rotate(45 20.686 43.313)" class="colorffbd69 svgShape"></path>
                        <rect width="6" height="14" x="29" y="25" fill="#ff69a0" transform="rotate(-45 32 32)" class="colorffbd69 svgShape"></rect>
                        <path fill="#2e222f" d="M22.1,29.172a8.952,8.952,0,0,0-2.6,5.7,5.042,5.042,0,0,0-.935-.091,4.966,4.966,0,0,0-3.535,1.465l-3.536,3.535a2,2,0,0,0,0,2.828l9.9,9.9a2,2,0,0,0,2.828,0l3.536-3.535A5,5,0,0,0,29.13,44.5a8.951,8.951,0,0,0,5.7-2.6L41.9,34.828a8.953,8.953,0,0,0,2.6-5.7,5.04,5.04,0,0,0,.936.089,4.984,4.984,0,0,0,3.535-1.462l3.536-3.536a2,2,0,0,0,0-2.828l-9.9-9.9a2,2,0,0,0-2.828,0L36.243,15.03A5,5,0,0,0,34.87,19.5a8.953,8.953,0,0,0-5.7,2.6Zm12.728,7.071-7.071-7.071,1.415-1.415,7.071,7.071Zm-9.9,9.9-2.122,2.121-7.071-7.071,2.122-2.121a1,1,0,0,1,1.414,0l5.656,5.656A1,1,0,0,1,24.929,46.143Zm0-7.07,0,0a5.006,5.006,0,0,1,0-7.07h0L32,39.071h0A5.006,5.006,0,0,1,24.93,39.072ZM39.071,17.858l2.122-2.121,7.071,7.071-2.121,2.122a1,1,0,0,1-1.415,0l-2.821-2.822L41.9,22.1l-.008-.007-2.821-2.821A1,1,0,0,1,39.071,17.858Zm0,7.071a5.006,5.006,0,0,1,0,7.071h0L32,24.929h0A5.006,5.006,0,0,1,39.071,24.929Z" class="color202040 svgShape"></path>
                        <line x1="29.172" x2="39.071" y1="24.929" y2="34.828" fill="none"></line>
                        <line x1="24.929" x2="34.828" y1="29.172" y2="39.071" fill="none"></line>
                      </svg>
                      <li><a href="#" class="productsNav">Products</a></li>
                    </div>
                    <h1 class="divider">|</h1>

                    <div class="faqsNavContainer">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 96 96" id="ChatQuestion">
                        <path fill="#ff69a0" stroke="#000000" stroke-width="5" d="M48.4 81.2C66.9568 81.2 82 66.1568 82 47.6C82 29.0432 66.9568 14 48.4 14C29.8432 14 14.8 29.0432 14.8 47.6C14.8 53.2995 16.2191 58.6676 18.7232 63.3701C19.0739 64.0286 19.1444 64.8049 18.8841 65.5041L13.7408 79.3231C13.0228 81.2521 14.8132 83.1738 16.7882 82.5938L32.5113 77.9762C33.1159 77.7987 33.7635 77.8597 34.3357 78.1238C38.6142 80.0984 43.3784 81.2 48.4 81.2Z" class="colorffb800 svgShape colorStroke000000 svgStroke"></path>
                        <path fill="#2e222f" d="M51 58.5C51 59.8807 49.8807 61 48.5 61C47.1193 61 46 59.8807 46 58.5C46 57.1193 47.1193 56 48.5 56C49.8807 56 51 57.1193 51 58.5Z" class="color000000 svgShape"></path>
                        <path stroke="#000000" stroke-linecap="round" stroke-width="5" d="M44 43.3902C44 40.9656 46.0147 39 48.5 39C50.9853 39 53 40.9656 53 43.3902C53 44.7088 52.4042 45.8916 51.4609 46.6964C50.1082 47.8504 48.5 49.2219 48.5 51V51" class="colorStroke000000 svgStroke"></path>
                      </svg>
                      <li><a href="#Faqs.html" class="faqsNav">FAQs</a></li>
                    </div>
                    <h1 class="divider">|</h1>

                     <img class="hamburgerLogo" src="images/navigationBarLogo.png" alt="ByteSize Logo">
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
        <a href="logout.php?logout">Log Out</a>
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

      <div class="animated">
          <p class="ourProductsHeader">Our Products</p>
          <p class="ourProductsDescription">Get ready to satisfy your sweet tooth with our handmade goodies! From soft and creamy pastillas to chewy graham balls and freshly baked cookies, every bite is made with love and a sprinkle of joy. Perfect for sharing—or keeping all to yourself!</p>
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

      <div class="missionVisionStart">
        <p class="missionVisionHeader">Our Delightful Goals</p>
        <p class="misionVisionDescription">Our vision is to spread smiles and sweetness everywhere we go, one treat at a time! We're on a mission to bake up joy with every bite—serving up delicious, lovingly made goodies that bring people together and make life a little sweeter.</p>
      </div>

      <p class="missionHeader">Mission</p>

      <div class="missionSection">
        <div class="missionLeft">
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

      <p class="visionHeader">Vision</p>
      <div class="visionSection">
        <img src="images/visionPicture.jpg" alt="Customer Picture" class="visionPicture">
        <div class="visionRight">
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
      <div class="topFooter">
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
      </div>
      <div class="RightFooter">
        <div class="F-Mascots">
          <div class="FM M1"><img src="HomePage/Cookie Mascot.png"></div>
          <div class="FM M2"><img src="HomePage/Pastillias Mascot.png"></div>
          <div class="FM M3"><img src="HomePage/GrahamBall Mascot.png"></div>
        </div>
      </div>
        <div class="F-Socials">
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

function toggleMenu() {
  const nav = document.getElementById("navLinks");
  nav.classList.toggle("show");
}

</script>

</html>