import Link from "next/link"
import Image from "next/image"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Navbar } from "@/components/navbar"
import { Footer } from "@/components/footer"
import { ArrowRight, Star, CheckCircle, Layers, Cog, Palette } from "lucide-react"

export default function HomePage() {
  const featuredModels = [
    {
      id: 1,
      name: "Mechanical Gear Assembly",
      category: "Engineering",
      image: "/placeholder.svg?height=300&width=400",
      material: "PLA+",
      printTime: "8 hours",
    },
    {
      id: 2,
      name: "Architectural Model",
      category: "Architecture",
      image: "/placeholder.svg?height=300&width=400",
      material: "Resin",
      printTime: "12 hours",
    },
    {
      id: 3,
      name: "Custom Phone Case",
      category: "Consumer",
      image: "/placeholder.svg?height=300&width=400",
      material: "TPU",
      printTime: "3 hours",
    },
  ]

  const services = [
    {
      icon: Layers,
      title: "Rapid Prototyping",
      description: "Fast turnaround for your design iterations and concept validation.",
    },
    {
      icon: Cog,
      title: "Custom Manufacturing",
      description: "Small to medium batch production with consistent quality.",
    },
    {
      icon: Palette,
      title: "Design Consultation",
      description: "Expert advice on design optimization for 3D printing.",
    },
  ]

  const testimonials = [
    {
      name: "Sarah Johnson",
      company: "TechStart Inc.",
      content: "Print3D Pro helped us prototype our product in record time. The quality exceeded our expectations!",
      rating: 5,
    },
    {
      name: "Mike Chen",
      company: "Design Studio",
      content: "Professional service and attention to detail. They've become our go-to 3D printing partner.",
      rating: 5,
    },
    {
      name: "Emily Rodriguez",
      company: "Maker Space",
      content: "Excellent communication and fast delivery. Highly recommend for any 3D printing needs.",
      rating: 5,
    },
  ]

  return (
    <div className="min-h-screen bg-background text-foreground">
      <Navbar />

      {/* Hero Section */}
      <section className="relative py-20 md:py-32 overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-br from-primary/10 via-transparent to-transparent" />
        <div className="container relative">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div className="space-y-8">
              <div className="space-y-4">
                <Badge variant="secondary" className="w-fit">
                  Professional 3D Printing Services
                </Badge>
                <h1 className="text-4xl md:text-6xl font-bold leading-tight">
                  Bring Your Ideas to <span className="text-primary">Life</span>
                </h1>
                <p className="text-xl text-muted-foreground max-w-lg">
                  From rapid prototyping to custom manufacturing, we deliver high-quality 3D printed parts with
                  precision and speed.
                </p>
              </div>
              <div className="flex flex-col sm:flex-row gap-4">
                <Button size="lg" asChild>
                  <Link href="/quote">
                    Get Quote <ArrowRight className="ml-2 h-4 w-4" />
                  </Link>
                </Button>
                <Button size="lg" variant="outline" asChild>
                  <Link href="/gallery">View Gallery</Link>
                </Button>
              </div>
              <div className="flex items-center gap-8 pt-4">
                <div className="text-center">
                  <div className="text-2xl font-bold text-primary">500+</div>
                  <div className="text-sm text-muted-foreground">Projects Completed</div>
                </div>
                <div className="text-center">
                  <div className="text-2xl font-bold text-primary">24h</div>
                  <div className="text-sm text-muted-foreground">Average Turnaround</div>
                </div>
                <div className="text-center">
                  <div className="text-2xl font-bold text-primary">99%</div>
                  <div className="text-sm text-muted-foreground">Client Satisfaction</div>
                </div>
              </div>
            </div>
            <div className="relative">
              <div className="absolute inset-0 bg-gradient-to-r from-primary/20 to-transparent rounded-3xl blur-3xl" />
              <Image
                src="/placeholder.svg?height=600&width=600"
                alt="3D Printer in action"
                width={600}
                height={600}
                className="relative rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* Featured Models */}
      <section className="py-20 bg-muted/30">
        <div className="container">
          <div className="text-center space-y-4 mb-16">
            <Badge variant="secondary" className="w-fit mx-auto">
              Featured Work
            </Badge>
            <h2 className="text-3xl md:text-4xl font-bold">Recent Projects</h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Explore some of our latest 3D printing projects across various industries and applications.
            </p>
          </div>
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {featuredModels.map((model) => (
              <Card key={model.id} className="group hover:shadow-lg transition-all duration-300 border-border/50">
                <div className="relative overflow-hidden rounded-t-lg">
                  <Image
                    src={model.image || "/placeholder.svg"}
                    alt={model.name}
                    width={400}
                    height={300}
                    className="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                  <Badge className="absolute top-4 left-4">{model.category}</Badge>
                </div>
                <CardHeader>
                  <CardTitle className="group-hover:text-primary transition-colors">{model.name}</CardTitle>
                  <CardDescription>
                    Material: {model.material} • Print Time: {model.printTime}
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <Button variant="outline" size="sm" asChild>
                    <Link href={`/models/${model.id}`}>
                      View Details <ArrowRight className="ml-2 h-3 w-3" />
                    </Link>
                  </Button>
                </CardContent>
              </Card>
            ))}
          </div>
          <div className="text-center mt-12">
            <Button variant="outline" size="lg" asChild>
              <Link href="/gallery">
                View All Projects <ArrowRight className="ml-2 h-4 w-4" />
              </Link>
            </Button>
          </div>
        </div>
      </section>

      {/* Services */}
      <section className="py-20">
        <div className="container">
          <div className="text-center space-y-4 mb-16">
            <Badge variant="secondary" className="w-fit mx-auto">
              Our Services
            </Badge>
            <h2 className="text-3xl md:text-4xl font-bold">What We Offer</h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Comprehensive 3D printing solutions tailored to your specific needs and requirements.
            </p>
          </div>
          <div className="grid md:grid-cols-3 gap-8">
            {services.map((service, index) => (
              <Card key={index} className="text-center border-border/50 hover:border-primary/50 transition-colors">
                <CardHeader>
                  <div className="mx-auto w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <service.icon className="h-6 w-6 text-primary" />
                  </div>
                  <CardTitle>{service.title}</CardTitle>
                  <CardDescription>{service.description}</CardDescription>
                </CardHeader>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Why Choose Us */}
      <section className="py-20 bg-muted/30">
        <div className="container">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <Image
                src="/placeholder.svg?height=500&width=600"
                alt="Quality Control"
                width={600}
                height={500}
                className="rounded-2xl shadow-lg"
              />
            </div>
            <div className="space-y-8">
              <div className="space-y-4">
                <Badge variant="secondary" className="w-fit">
                  Why Choose Us
                </Badge>
                <h2 className="text-3xl md:text-4xl font-bold">Quality & Precision Guaranteed</h2>
                <p className="text-muted-foreground">
                  We combine cutting-edge technology with expert craftsmanship to deliver exceptional results every
                  time.
                </p>
              </div>
              <div className="space-y-4">
                <div className="flex items-start space-x-3">
                  <CheckCircle className="h-5 w-5 text-primary mt-0.5 flex-shrink-0" />
                  <div>
                    <h4 className="font-semibold">Fast Turnaround</h4>
                    <p className="text-sm text-muted-foreground">Most projects completed within 24-48 hours</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="h-5 w-5 text-primary mt-0.5 flex-shrink-0" />
                  <div>
                    <h4 className="font-semibold">Premium Materials</h4>
                    <p className="text-sm text-muted-foreground">Wide selection of high-quality printing materials</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="h-5 w-5 text-primary mt-0.5 flex-shrink-0" />
                  <div>
                    <h4 className="font-semibold">Expert Support</h4>
                    <p className="text-sm text-muted-foreground">Professional guidance throughout your project</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-20">
        <div className="container">
          <div className="text-center space-y-4 mb-16">
            <Badge variant="secondary" className="w-fit mx-auto">
              Testimonials
            </Badge>
            <h2 className="text-3xl md:text-4xl font-bold">What Our Clients Say</h2>
          </div>
          <div className="grid md:grid-cols-3 gap-8">
            {testimonials.map((testimonial, index) => (
              <Card key={index} className="border-border/50">
                <CardHeader>
                  <div className="flex items-center space-x-1 mb-2">
                    {[...Array(testimonial.rating)].map((_, i) => (
                      <Star key={i} className="h-4 w-4 fill-primary text-primary" />
                    ))}
                  </div>
                  <CardDescription className="text-base">"{testimonial.content}"</CardDescription>
                </CardHeader>
                <CardContent>
                  <div>
                    <div className="font-semibold">{testimonial.name}</div>
                    <div className="text-sm text-muted-foreground">{testimonial.company}</div>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-gradient-to-r from-primary/10 via-primary/5 to-transparent">
        <div className="container text-center">
          <div className="max-w-3xl mx-auto space-y-8">
            <h2 className="text-3xl md:text-4xl font-bold">Ready to Start Your Project?</h2>
            <p className="text-xl text-muted-foreground">
              Get a free quote today and see how we can bring your ideas to life with precision 3D printing.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Button size="lg" asChild>
                <Link href="/quote">
                  Get Free Quote <ArrowRight className="ml-2 h-4 w-4" />
                </Link>
              </Button>
              <Button size="lg" variant="outline" asChild>
                <Link href="/contact">Contact Us</Link>
              </Button>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  )
}
