/**
 * Adobe Helium: symbol definitions
 */
window.symbols = {
"stage": {
   version: "0.1",
   baseState: "Base State",
   initialState: "Base State",
   parameters: {

   },
   content: {
      dom: [
        {
            id:'Image1',
            type:'image',
            rect:[0,0,345,3150],
            fill:['rgba(0,0,0,0)','images/spritelogos1.jpg'],
        },
      ],
      symbolInstances: [
      ],
   },
   states: {
      "Base State": {
         "#Image1": [
            ["transform", "translateY", '-3000px']
         ],
         "#stage": [
            ["color", "background-color", 'rgba(255,255,255,1)'],
            ["style", "width", '345px'],
            ["style", "height", '150px'],
            ["style", "overflow", 'hidden']
         ]
      }
   },
   actions: {

   },
   bindings: [

   ],
   timelines: {
      "Default Timeline": {
         fromState: "Base State",
         toState: "",
         duration: 20000,
         timeline: [
            { id: "eid52", tween: [ "transform", "#Image1", "translateY", '-3000px', { valueTemplate: undefined, fromValue: '-3000px'}], position: 0, duration: 0, easing: "swing" },
            { id: "eid55", tween: [ "transform", "#Image1", "translateY", '-2850px', { valueTemplate: undefined, fromValue: '-3000px'}], position: 500, duration: 500, easing: "swing" },
            { id: "eid57", tween: [ "transform", "#Image1", "translateY", '-2700px', { valueTemplate: undefined, fromValue: '-2850px'}], position: 1500, duration: 500, easing: "swing" },
            { id: "eid59", tween: [ "transform", "#Image1", "translateY", '-2550px', { valueTemplate: undefined, fromValue: '-2700px'}], position: 2500, duration: 500, easing: "swing" },
            { id: "eid62", tween: [ "transform", "#Image1", "translateY", '-2400px', { valueTemplate: undefined, fromValue: '-2550px'}], position: 3500, duration: 500, easing: "swing" },
            { id: "eid64", tween: [ "transform", "#Image1", "translateY", '-2250px', { valueTemplate: undefined, fromValue: '-2400px'}], position: 4500, duration: 500, easing: "swing" },
            { id: "eid66", tween: [ "transform", "#Image1", "translateY", '-2100px', { valueTemplate: undefined, fromValue: '-2250px'}], position: 5500, duration: 500, easing: "swing" },
            { id: "eid68", tween: [ "transform", "#Image1", "translateY", '-1950px', { valueTemplate: undefined, fromValue: '-2100px'}], position: 6500, duration: 500, easing: "swing" },
            { id: "eid70", tween: [ "transform", "#Image1", "translateY", '-1800px', { valueTemplate: undefined, fromValue: '-1950px'}], position: 7500, duration: 500, easing: "swing" },
            { id: "eid72", tween: [ "transform", "#Image1", "translateY", '-1650px', { valueTemplate: undefined, fromValue: '-1800px'}], position: 8500, duration: 500, easing: "swing" },
            { id: "eid74", tween: [ "transform", "#Image1", "translateY", '-1500px', { valueTemplate: undefined, fromValue: '-1650px'}], position: 9500, duration: 500, easing: "swing" },
            { id: "eid76", tween: [ "transform", "#Image1", "translateY", '-1350px', { valueTemplate: undefined, fromValue: '-1500px'}], position: 10500, duration: 500, easing: "swing" },
            { id: "eid79", tween: [ "transform", "#Image1", "translateY", '-1200px', { valueTemplate: undefined, fromValue: '-1350px'}], position: 11500, duration: 500, easing: "swing" },
            { id: "eid81", tween: [ "transform", "#Image1", "translateY", '-1050px', { valueTemplate: undefined, fromValue: '-1200px'}], position: 12500, duration: 500, easing: "swing" },
            { id: "eid83", tween: [ "transform", "#Image1", "translateY", '-900px', { valueTemplate: undefined, fromValue: '-1050px'}], position: 13500, duration: 500, easing: "swing" },
            { id: "eid85", tween: [ "transform", "#Image1", "translateY", '-750px', { valueTemplate: undefined, fromValue: '-900px'}], position: 14500, duration: 500, easing: "swing" },
            { id: "eid87", tween: [ "transform", "#Image1", "translateY", '-600px', { valueTemplate: undefined, fromValue: '-750px'}], position: 15500, duration: 500, easing: "swing" },
            { id: "eid89", tween: [ "transform", "#Image1", "translateY", '-450px', { valueTemplate: undefined, fromValue: '-600px'}], position: 16500, duration: 500, easing: "swing" },
            { id: "eid91", tween: [ "transform", "#Image1", "translateY", '-300px', { valueTemplate: undefined, fromValue: '-450px'}], position: 17500, duration: 500, easing: "swing" },
            { id: "eid93", tween: [ "transform", "#Image1", "translateY", '-150px', { valueTemplate: undefined, fromValue: '-300px'}], position: 18500, duration: 500, easing: "swing" },
            { id: "eid95", tween: [ "transform", "#Image1", "translateY", '0px', { valueTemplate: undefined, fromValue: '-150px'}], position: 19500, duration: 500, easing: "swing" }]
      }
   },
}};

/**
 * Adobe Edge DOM Ready Event Handler
 */
$(window).ready(function() {
     $.Edge.initialize(symbols);
});
/**
 * Adobe Edge Timeline Launch
 */
$(window).load(function() {
    $.Edge.play();
});
