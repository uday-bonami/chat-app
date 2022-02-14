'use strict';

// Dom Elements
const QuoteImg = document.querySelectorAll('.Quote_Image_Div');
const TestimonialCardDiv = document.querySelector('.Testimonial__Card_Div');
const quoteText = document.querySelector('.quote__text');
const QuoteUserName = document.querySelector('.Quote__UserName');
const CloseSideBarButton = document.querySelector('.icon__Close');
const SideBarComponent = document.querySelector('.SideBar__Div');
const OverLayContainer = document.querySelector('.OverLay_Div');
const writeBtn = document.querySelectorAll('.writeBtn');
const SelfSummeryInputDiv = document.querySelector('.Self__Summary');
const SummeryDetailsInput = document.querySelector('.Summery_Details');
const SubmitDetailsButton = document.querySelector('.submitButtonText');
const SelectoCityFromContainer = document.querySelector('.Select_City_From');
const PlanPricePara = document.querySelector('.Plan_Price_Para');
const planDisCountData = document.querySelector('.Plan_Discount_Data');
const PaymentCardDiv = document.querySelectorAll('.Payment_Card_Div');
const AmountPayBill = document.querySelector('.Amount_PLayBill_Data');
const TotalPayData = document.querySelector('.Total_Pay_Data');
const CardFileDiv = document.querySelectorAll('.User_card_with_flip');
const tabCardDiv = document.querySelectorAll('.Tabs_Tag');
const ChatContainerUserDiv = document.querySelectorAll('.chat_container-2-semi3-list');
const ChatBoxDiv = document.querySelector('.chat_container-3');

// Contry Api
const ApiData = `https://restcountries.com/v3.1/all`;

const CreateDomElement = function (data) {
  const html = `<option value="${data}">${data}</option>`;

  // Insert the html doc into the dom elements
  SelectoCityFromContainer.insertAdjacentHTML('beforeend', html);
};

// Getting the data
const FetchApiData = async function () {
  await fetch(ApiData)
    .then((res) => res.json())
    .then((data) => {
      data.forEach((el) => {
        CreateDomElement(el.name.common);
      });
    });
};

// Fetch Data from the server
FetchApiData();

// Quote User Data
const QuoteUserData = [
  {
    id: 'Quote_One',
    userName: 'Fina',
    text: `Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,`,
  },
  {
    id: 'Quote_Two',
    userName: 'Riya',
    text: `Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.`,
  },
  {
    id: 'Quote_Three',
    userName: 'Mena',
    text: `Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.`,
  },
  {
    id: 'Quote_Four',
    userName: 'Sam',
    text: `Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,`,
  },
  {
    id: 'Quote_Five',
    userName: 'Sami',
    text: `of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and`,
  },
  {
    id: 'Quote_Six',
    userName: 'Dheeraj',
    text: `here are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a `,
  },
  {
    id: 'Quote_Seven',
    userName: 'Dony',
    text: `old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur`,
  },
];

QuoteImg.forEach((item) => {
  item.addEventListener('click', (e) => {
    // Adding class into the quote div
    TestimonialCardDiv.classList.add('scaleQuoteDivClass');
    // Find the user data
    const UserDataFind = QuoteUserData.find((el) => el.id === e.target.id);
    // Show into the Quote Area
    if (UserDataFind) {
      quoteText.textContent = UserDataFind.text;
      QuoteUserName.textContent = UserDataFind.userName;
    }

    // If the Quote div has active class then remove it
    if (TestimonialCardDiv.classList.contains('scaleQuoteDivClass')) {
      setTimeout(() => {
        TestimonialCardDiv.classList.remove('scaleQuoteDivClass');
      }, 300);
    }
  });
});

// SideBar Hide and Show Animation
const SideBarShowAndHideFunction = function () {
  SideBarComponent.classList.toggle('ToggleSideBar');
  // Sidebar Close or Open
  if (CloseSideBarButton.classList.contains('fa-times')) {
    CloseSideBarButton.classList.replace('fa-times', 'fa-bars');
  } else {
    CloseSideBarButton.classList.replace('fa-bars', 'fa-times');
  }
};

// Payment card section
// Remove the active payment card
const removeCardActive = function () {
  PaymentCardDiv.forEach((el) => {
    el.classList.remove('Payment_Card_Div_active');
  });
};

PaymentCardDiv.forEach((el) => {
  el.addEventListener('click', function (e) {
    // Remove the active bar class from the price div
    removeCardActive();
    // Add Active Card style
    el.classList.add('Payment_Card_Div_active');

    // Price card all children data
    const pricePlanArr = [...el.children];

    // Get the Price data
    const priceData = Number(pricePlanArr[4].textContent.split('$')[1]);

    // Show the data from the total card div
    PlanPricePara.textContent = `$${priceData}`;
    TotalPayData.textContent = `$${priceData}`;
    AmountPayBill.textContent = `$${priceData}`;
  });
});

// Flip the user cards
CardFileDiv.forEach((el) => {
  el.addEventListener('dblclick', function () {
    el.classList.toggle('cardFlipActive');
  });
});

// User card active class tabs
const removingBorder = function () {
  tabCardDiv.forEach((el) => {
    el.classList.remove('active_Tab_Color');
  });
};

tabCardDiv.forEach((el) => {
  el.addEventListener('click', function () {
    // Removing Class from the user Card
    removingBorder();
    el.classList.add('active_Tab_Color');
  });
});

// Events
// Side Bar Event
CloseSideBarButton.addEventListener('click', SideBarShowAndHideFunction);
// Submit Details
SubmitDetailsButton.addEventListener('click', UpdataDetials);
