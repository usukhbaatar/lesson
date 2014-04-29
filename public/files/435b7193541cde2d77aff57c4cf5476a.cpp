#include <cstring>
#include <iostream>
#include <cstdio>

using namespace std;

int isPrime(int n) {
    for (int i = 2; i * i <= n; i++) {
        if (n % i == 0) return 0;
    }
    return 1;
}

int main() {
    freopen("out.txt", "w", stdout);
    int t = 8924;
    long long sum = 0;
    for (int i = 2; t > 0; i++) {
        if (isPrime(i)) {
            sum += i;
            t--;
        }
    }
    cout << sum;
    return 0;
}
