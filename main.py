#! /usr/bin/env python
import random
import string
import time
from contextlib import contextmanager

from pympler import asizeof

long_key = "a_key_with_a_very_long_name_"


@contextmanager
def timer(msg):
    t0 = time.perf_counter()
    try:
        yield
    finally:
        t1 = time.perf_counter()
        elapsed = t1 - t0
        print(f"{msg}: {elapsed=:0.4f}")


class SlotTest:
    __slots__ = tuple([f"{long_key}{i:02}" for i in range(20)])

    def __init__(self):
        for i in range(20):
            v = "".join(random.choices(string.ascii_lowercase, k=20))
            setattr(self, f"{long_key}{i:02}", v)


class DictTest:
    def __init__(self):
        for i in range(20):
            v = "".join(random.choices(string.ascii_lowercase, k=20))
            setattr(self, f"{long_key}{i:02}", v)


def hash_test():
    h = {}
    for i in range(0, 20):
        v = "".join(random.choices(string.ascii_lowercase, k=20))
        h[f"{long_key}{i:02}"] = v

    return h


class SlotVector:
    __slots__ = ["x", "y"]

    def __init__(self):
        self.x = random.random()
        self.y = random.random()


class DictVector:
    def __init__(self):
        self.x = random.random()
        self.y = random.random()


if __name__ == "__main__":
    n = 1_000_000
    for name in ["SlotVector", "DictVector", "SlotTest", "DictTest"]:
        with timer(name):
            v = [globals()[name]() for _ in range(n)]
            size = asizeof.asizeof(v)

        print(f"Sizing {name}")
        print(f"Instance: {asizeof.asizeof(v[1])} bytes")
        print(f"1 mio instances: {size / n:4.2f} bytes per instance")
        print()

    with timer("HashTest"):
        h = [hash_test() for _ in range(n)]
        as_h = asizeof.asizeof(h)

    print("Sizing hash_test")
    print(f"Deep size of instance: {asizeof.asizeof(h[1])} bytes")
    print(f"Total size (with deep size of objects): {as_h / n:4.2f} bytes")
    print()
