import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
  // Key configurations for Stress in this section
  stages: [
    { duration: '1m', target: 800 }, // traffic ramp-up from 1 to a higher 200 users over 10 minutes.
    // { duration: '5s', target: 150 }, // stay at higher 200 users for 30 minutes
    // { duration: '5s', target: 180 }, // ramp-down to 180 users
    // { duration: '5s', target: 0 }, // ramp-down to 0 users
  ],
};

export default () => {
  const urlRes = http.get('https://test-api.k6.io');
  sleep(1);
};
