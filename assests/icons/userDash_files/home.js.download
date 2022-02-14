'use strict';

// Dom Elements
const findZondicBtn = document.querySelector('.find_Zondic_Btn');
let year = document.querySelector('.year');
const ZondicDate = document.querySelector('.Zondic_Date');
const ziodicimg = document.querySelector('.ziodicimg');
const ziodicText = document.querySelector('.ziodicText');
const timeb = document.querySelector('.timeb');
const ziodicpara = document.querySelector('.ziodicpara');

// Footer copywrite date Change Auto
let a = new Date();
let update = a.getFullYear();
year.style.color = '#fff';
year.textContent = update;

// User Zondic find object
let userZondicFindObject = [
  {
    img: './assests/images/Aries.png',
    Title: 'Aries',
    desc: 'Those born under the Aries zodiac sign often have an exciting and enthusiastic energy. They often seek new and challenging adventures that can push their limits. They are driven, ambitious and curious, and aries tends to have a strong sense of justice. They love competition, in all its forms. They are generally quite optimistic, and they love being placed in leadership positions.',
  },
  {
    img: './assests/images/pisces.png',
    Title: 'Pisces',
    desc: 'The Pisces zodiac sign are the dreamers and mystics of the zodiac - but you may never know it. Many of them have extremely vivid inner lives - filled with fantasy, magic and wonder. They may find it hard to express that inner life, meaning that many of them are introverts. They are honest, compassionate, and trustworthy but they can sometimes take it too far and be rather gullible. Because of that they can be taken advantage of. Beneath their quiet exterior, Pisces has an intense determination, which helps them transcend any obstacles that come their way.',
  },
  {
    img: './assests/images/Taurus.png',
    Title: 'Taurus',
    desc: 'People born under the Taurus zodiac sign are often incredibly dedicated, reliable and dependable. Above all things, they value their sense of security and stability.  After Aries brings its fiery energy, it is Taurus that lays down the foundations and follows through. They tend to be rather stubborn and dislike change. When they settle with a routine that they like, it can take much effort to get them to change. ',
  },
  {
    img: './assests/images/Germini.png',
    Title: 'Gemini',
    desc: 'Those born under the Gemini zodiac sign enjoy socializing and love surrounding themselves with people. They are ruled by the planet Mercury, and so they are never happier than when they are sharing their ideas and communicating with the people around them. They enjoy chit-chat and tend to have expression and communication very high on their list of priorities. Sometimes their love for sharing themselves with others, and their never-ending list of ideas can make them seem nervous, excited, and sometimes even manic.',
  },
  {
    img: './assests/images/cancer.png',
    Title: 'Cancer',
    desc: 'Those born under the zodiac sign Cancer need to be needed. They have an great desire to feel loved and appreciated in every part of their lives. This is needed so that they can develop a sense of security and identity. To the Cancer zodiac sign, their sense of home is very important to their feeling of safety and comfort. They find it rather difficult to achieve unless they feel safe in their home. They are talented at developing home environments for people that are close to them - in both an emotional and physical sense. ',
  },
  {
    img: './assests/images/leo.png',
    Title: 'Leo',
    desc: 'Leos tend to have almost a royal air about them. Their planetary ruler is the Sun, and so they are talented at bringing warmth, life and light into the relationships that are important to them. Many Leos will have a large group of friends that adore them. They have a kind of natural charisma which often makes other signs gravitate towards them. Like their planetary ruler, Leos love to be at the center of attention and they deeply appreciate compliments and even flattery. Their happy and outgoing attitude towards life makes them pleasurable to be around. ',
  },
  {
    img: './assests/images/virgo.png',
    Title: 'Virgo',
    desc: 'Those born under the Virgo zodiac sign have capable, organized and analytical minds, which often makes them a pleasure to chat with. Even when they have rather fantastic stories, the charming way they tell them can make those stories convincing. Virgos are curious people, and they have a natural gift for research - whether it comes to assignments, or even people. They also often have great memory and a talent for intuition. They make for excellent team members in both work and social situations. They love to collaborate, although their sometimes critical nature can annoy others when those criticisms are not understood.',
  },
  {
    img: './assests/images/libra.png',
    Title: 'Libra',
    desc: 'The zodiac sign Libra is thrives when their needs of balance, justice, and stability are met. They are charming creatures that somehow always surround themselves with a sense of beauty and harmony. Admittedly, some of them can go to extremes searching for that harmony - which can make their situations unreasonable or unhealthy. Their ruling planet is Venus meaning that Libras are nurturing, caring, and they can make great defenders of the downtrodden. Sometimes, they can be shy if they find difficulties in coming out of their shell and letting their guard down. Despite their more introverted side they still love a good debate.',
  },
  {
    img: './assests/images/scorpio.png',
    Title: 'Scorpio',
    desc: 'Unfortunately, those born under the Scorpio zodiac sign are often misunderstood. They are quite bold, with intense personalities and feelings that hide underneath their cool exterior. They are capable people that can complete great and massive projects with control and confidence. Their intensity when approaching a situation means that they can surmount almost all obstacles if they can truly put their mind to the task. Many Scorpios have an unshakable focus when they need to call on it. However, they are often secretive, seeming withdrawn and uninterested, when they are actually keenly observing.',
  },
  {
    img: './assests/images/sagittarius.png',
    Title: 'Sagittarius',
    desc: 'The Sagittarius zodiac sign often gains the reputation of the philosopher among their fellow zodiac signs. They do have a great ability to focus, but this may be surprising since many of them love exploring and wandering the world, tasting all the pleasures of life. From an early age, they must learn how to channel their energy or else they risk stretching themselves out too thin going in too many directions. They often are hasty individuals and lack patience. When they encounter failure they can sometimes make a sudden comeback, much to the surprise of others. While they are loyal friends, they may find it hard to commit as this can run counter to their desire for freedom and expansion. ',
  },
  {
    img: './assests/images/capricorn.png',
    Title: 'Capricorn',
    desc: "Those born under the Capricorn zodiac sign are talented at applying their keen intelligence and ambition to practical matters.  Stability and order are important to them - and this makes them good organizers. Their goals are often lofty, and they achieve them slowly - but purposefully, and systematically. They are gifted with a sharp intuition, although they can be rather secretive about what they perceive. They are patient with themselves - they have confidence that they can accomplish all their goals if they follow their step-by-step plan. They are responsible people that often take the heavy burden of others - whether willingly, or just because they are so capable. However, they find it difficult to share their own troubles and can struggle with depression if they don't learn how to express their feelings.",
  },
  {
    img: './assests/images/Aquarius.png',
    Title: 'Aquarius',
    desc: "Aquarius often comes off as an oddball - they have quirky personalities and quietly go about accomplishing their goals in quiet, and unorthodox ways. Oftentimes, just because Aquarius chooses to take the path less traveled, the results of their eccentric methods are surprisingly effective. They are the humanitarians of the zodiac, taking up banners for the greater good of humanity. Many of them are also easy going and their peculiarity alongside their curious nature make them fast friendships. Sometimes, if they don't strive to motivate themselves, they can succumb to laziness. Many are often gifted with a strong sense of art and poetry.",
  },
];

// Find user zondic
findZondicBtn.addEventListener('click', function () {
  const value = ZondicDate.value.split('-');
  const Month = value[1];
  const Dates = value[2];

  let showResult = [
    {
      img: '',
      Title: '',
      desc: '',
    },
  ];

  if ((Month == 3 && Dates > 21) || (Month == 4 && Dates < 19)) {
    showResult = [
      {
        img: userZondicFindObject[0].img,
        Title: userZondicFindObject[0].Title,
        desc: userZondicFindObject[0].desc,
      },
    ];
  } else if ((Month == 2 && Dates > 20) || (Month == 3 && Dates < 20)) {
    showResult = [
      {
        img: userZondicFindObject[1].img,
        Title: userZondicFindObject[1].Title,
        desc: userZondicFindObject[1].desc,
      },
    ];
  } else if ((Month == 4 && Dates > 20) || (Month == 5 && Dates < 20)) {
    showResult = [
      {
        img: userZondicFindObject[2].img,
        Title: userZondicFindObject[2].Title,
        desc: userZondicFindObject[2].desc,
      },
    ];
  } else if ((Month == 5 && Dates > 21) || (Month == 6 && Dates < 20)) {
    showResult = [
      {
        img: userZondicFindObject[3].img,
        Title: userZondicFindObject[3].Title,
        desc: userZondicFindObject[3].desc,
      },
    ];
  } else if ((Month == 6 && Dates > 21) || (Month == 7 && Dates < 22)) {
    showResult = [
      {
        img: userZondicFindObject[4].img,
        Title: userZondicFindObject[4].Title,
        desc: userZondicFindObject[4].desc,
      },
    ];
  } else if ((Month == 7 && Dates > 21) || (Month == 8 && Dates < 22)) {
    showResult = [
      {
        img: userZondicFindObject[5].img,
        Title: userZondicFindObject[5].Title,
        desc: userZondicFindObject[5].desc,
      },
    ];
  } else if ((Month == 8 && Dates > 23) || (Month == 9 && Dates < 22)) {
    showResult = [
      {
        img: userZondicFindObject[6].img,
        Title: userZondicFindObject[6].Title,
        desc: userZondicFindObject[6].desc,
      },
    ];
  } else if ((Month == 9 && Dates > 23) || (Month == 10 && Dates < 22)) {
    showResult = [
      {
        img: userZondicFindObject[7].img,
        Title: userZondicFindObject[7].Title,
        desc: userZondicFindObject[7].desc,
      },
    ];
  } else if ((Month == 10 && Dates > 23) || (Month == 11 && Dates < 22)) {
    showResult = [
      {
        img: userZondicFindObject[8].img,
        Title: userZondicFindObject[8].Title,
        desc: userZondicFindObject[8].desc,
      },
    ];
  } else if ((Month == 11 && Dates > 23) || (Month == 12 && Dates < 21)) {
    showResult = [
      {
        img: userZondicFindObject[9].img,
        Title: userZondicFindObject[9].Title,
        desc: userZondicFindObject[9].desc,
      },
    ];
  } else if ((Month == 12 && Dates > 22) || (Month == 1 && Dates < 21)) {
    showResult = [
      {
        img: userZondicFindObject[10].img,
        Title: userZondicFindObject[10].Title,
        desc: userZondicFindObject[10].desc,
      },
    ];
  } else if ((Month == 1 && Dates > 19) || (Month == 2 && Dates < 19)) {
    showResult = [
      {
        img: userZondicFindObject[11].img,
        Title: userZondicFindObject[11].Title,
        desc: userZondicFindObject[11].desc,
      },
    ];
  }

  // console.log(showResult);
  if (Month == null && Dates == null) {
    ziodicimg.src = './assests/images/Artboard%204%202.png';
    ziodicText.innerText = 'Please Fill the form foe Zodiac';
    console.log(showResult);
  } else {
    ziodicimg.src = `${showResult[0].img}`;
    ziodicText.innerText = `${showResult[0].Title}`;
    ziodicpara.innerText = `${showResult[0].desc}`;
    console.log(showResult);
  }
});
