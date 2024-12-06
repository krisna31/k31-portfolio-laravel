import http from "k6/http";
import { sleep } from "k6";

export const options = {
    vus: 500,
    duration: "1m",
};

// The default exported function is gonna be picked up by k6 as the entry point for the test script. It will be executed repeatedly in "iterations" for the whole duration of the test.
export default function () {
    const urlRes = http.get('https://k31.my.id');
    sleep(1);
}
