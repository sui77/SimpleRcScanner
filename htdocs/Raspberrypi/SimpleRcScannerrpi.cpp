#include <wiringPi.h>
#include <stdlib.h>
#include <stdio.h>

#define SAMPLESIZE 500

static unsigned int timings[SAMPLESIZE];
static unsigned int pos = 0;
static unsigned long lastTime = 0;
static bool recording = false;


void handleInterrupt() {
    if (recording == false) return;
    const long time = micros();
    timings[pos] = time - lastTime;
    lastTime = time;
    if (++pos > SAMPLESIZE-1) {
        pos = 0;
    }
}

int main(int argc, char *argv[]) {

    // This pin is not the first pin on the RPi GPIO header!
    // Consult https://projects.drogon.net/raspberry-pi/wiringpi/pins/
    // for more information.
    static int receiverPin = 2;

    if (wiringPiSetup() == -1) {
        printf("wiringPiSetup failed, exiting...");
        return 0;
    }


    wiringPiISR(receiverPin, INT_EDGE_BOTH, &handleInterrupt);
    recording = true;

    for (int i = 5; i>0; i--) {
        printf("%i... ", i );
        fflush(stdout);
        delay(1000);
    }
    recording = false;
    int finalstate = digitalRead(receiverPin);

    printf("\n");

    for (unsigned int i = pos + finalstate; i< SAMPLESIZE; i++) {
        printf("%i,", timings[i] );
    }

    for (unsigned int i = 0; i < pos; i++) {
        printf("%i,", timings[i] );
    }

    printf("\n");

}
