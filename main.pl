#!/usr/bin/env perl
use strict;
use warnings;
use Devel::Size qw(total_size);
use Time::HiRes qw(gettimeofday);

sub random_string {
    my $length = shift;
    join '', map { ('a'..'z')[rand 26] } 1..$length;
}

package DictTest {
    sub new {
        my $class = shift;
        my $self = bless {}, $class;
        for my $i (0..19) {
            $self->{"a_key_with_a_very_long_name_$i"} = main::random_string(20);
        }
        return $self;
    }
}

my $n = 1_000_000;
my $start_time = gettimeofday();
my @d = map { DictTest->new() } 1..$n;
my $end_time = gettimeofday();

my $one_size = total_size($d[1]);
my $average_size = total_size(\@d)/$n;
my $delta_time = $end_time - $start_time;

print "Time: $delta_time\n";
print "Instance: $one_size bytes.\n";
print "1 mio instances: $average_size bytes per instance.\n";

